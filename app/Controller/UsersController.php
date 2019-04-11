<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
    public $helpers = array(
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Flash');
    public $components = array('Flash','Paginator');

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('add', 'logout');
    }

    /**
     * View all users.
     * @return void
     */
    public function index() {
        $this->set('users', $this->User->find('all', array(
            'order' => array('User.created' => 'desc'),
            'contain' => 'UserRole'
        )));
    }

    /**
     * View a user's profile, posts, and account settings if authorized to change them.
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function view($id = null) {
        $data = $this->User->getById($id, array(
                'UserPosts' => array(
                    'order' => array('UserPosts.modified' => 'desc')
                ),
                'UserRole'
            )
        );

        $this->set('user', $data['User']);
        $this->set('posts', $data['UserPosts']);
        $this->set('role', $data['UserRole']);
        $this->set('isAccountOwner', $this->Auth->user('id') === $id);
        $this->set('canEditPass', $this->_isActionAuthorised($this->Auth->user(), 'editpass'));
        $this->set('canDelete', $this->_isActionAuthorised($this->Auth->user(), 'delete'));
        if($this->_isActionAuthorised($this->Auth->user(), 'editrole')) {
            $this->set('canEditRole', true);
            $allRoles = array_column($this->User->UserRole->getAll(), 'UserRole');
            $this->set('allRoles', $allRoles);
        } else {
            $this->set('canEditRole', false);
            $this->set('allRoles', array());
        }
    }

    /**
     * Registers a new user.
     * @return CakeResponse|null
     * @throws Exception
     */
    public function add() {
        if ($this->request->is('post')) {
            // Prevent new users from setting elevated permissions.
            $this->request->data['User']['role_id'] = null;

            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $user = $this->User->getById($this->User->id, 'UserRole');
                unset($user['User']['password']);
                $user['User']['UserRole'] = $user['UserRole'];
                $this->Auth->login($user['User']);
                $this->Flash->success(
                    __('The user account %s has been created.',
                        h($this->request->data['User']['username']))
                );
                return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
            } else {
                $this->Flash->error(__('The user account could not be created. Please try again.'));
            }
        }
    }

    /**
     * Edits a user's password, if a correct current password is provided.
     * @param array $id
     * @return CakeResponse|null
     * @throws Exception
     */
    public function editpass($id = null) {
        $this->request->allowMethod('post');
        $user = $this->User->getById($id, array());

        $oldPassword = $this->request->data['User']['old_password'];
        if($this->User->checkPassword($oldPassword, $user)) {
            $newUser = array('User' => array(
                'password' => $this->request->data['User']['new_password']
            ));
            $this->User->id = $id;
            if($this->User->save($newUser, true, array('password'))) {
                $this->Flash->success(__("Your password has been updated."));
            } else {
                $this->Flash->error(__("Your password could not be updated."));
            }
        } else {
            $this->Flash->error(__('Invalid password.'));
        }
        return $this->redirect(array('action' => 'view', $id));
    }

    /**
     * Sets a user's role.
     * @return CakeResponse|null
     * @throws Exception
     */
    public function editrole() {
        $this->request->allowMethod('post');
        if(!isset($this->request->data['User']['id'])) throw new BadRequestException();
        $id = $this->request->data['User']['id'];
        if(!$this->User->exists($id)) throw new NotFoundException('Invalid user');

        $this->User->id = $id;
        $user = array('User' => array(
            'role_id' => $this->request->data['User']['role_id']
        ));
        if($this->User->save($user, true, array('role_id'))) {
            $this->Flash->success(__("The user's role has been updated."));
        } else {
            $this->Flash->error(__("The user's role could not be updated."));
        }
        return $this->redirect(array('action' => 'view', $id));
    }

    /**
     * Deletes a user account.
     * @param string $id
     * @return CakeResponse|null
     * @throws NotFoundException
     */
    public function delete($id = null) {
        $this->request->allowMethod('post', 'delete');

        if (!isset($id) || !$this->User->exists($id)) throw new NotFoundException(__('Invalid user'));

        if ($this->User->delete($id)) {
            $this->Flash->success(__('The user account has been deleted.'));
            if($this->Auth->user('id') === $id) $this->Auth->logout();
        } else {
            $this->Flash->error(__('The account could not be deleted. Please try again.'));
        }
        return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
    }

    /**
     * Attempts to log a user into their account using the provided credentials.
     * @return CakeResponse|null
     */
    public function login() {
        if($this->request->is('post')) {
            if($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password.'));
        }
    }

    /**
     * Logs the user out of their current session.
     * @return CakeResponse|null
     */
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user) {
        return $this->_isActionAuthorised($user, $this->action);
    }

    /**
     * Checks if any action is authorised for a given user.
     * @param array $user The user attempting the action.
     * @param string $action The action being attempted, as reported by $this->action. e.g. 'index'
     * @return bool True if the action is authorised, false otherwise.
     */
    protected function _isActionAuthorised($user, $action) {
        if(!isset($user)) return false;
        switch($action) {
            case 'delete':
            case 'editpass':
                if(!isset($this->request->params['pass'][0])) return false;
                $reqUserId = $this->request->params['pass'][0];
                return $user['id'] === $reqUserId;
            case 'editrole':
                return $user['UserRole']['edit_user_role'];
            default:
                return false;
        }
    }
}
