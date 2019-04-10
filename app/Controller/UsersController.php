<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash','Paginator');

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('add', 'logout', 'login');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->contain('UserRole');
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
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
        $this->set('isAccountOwner', $this->_isRequestedUser($this->Auth->user()));
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
     * add method
     *
     * @return CakeResponse|null
     * @throws Exception
     */
    public function add() {
        if ($this->request->is('post')) {
            // Prevent new users from setting elevated permissions.
            $this->request->data['User']['role_id'] = null;

            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->alert(
                    __('The user account %s has been created.',
                        h($this->request->data['User']['username'])),
                    array(
                        'plugin' => 'BoostCake',
                        'params' => array('class' => 'alert-success alert-dismissible')
                ));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->alert(__('The user account could not be created. Please try again.'), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-warning alert-dismissible')
                ));
            }
        }
    }

    /**
     * Sets a user's role.
     * @return CakeResponse|null
     * @throws Exception
     */
    public function editrole() {
        $id = $this->request->data['User']['id'];
        $role_id = $this->request->data['User']['role_id'];

        if($this->request->is('post')) {
            $user = array('User' => array(
                'id' => $id,
                'role_id' => $role_id
            ));
            if($this->User->save($user)) {
                $this->Flash->alert(__("The user's role has been updated successfully."), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-success alert-dismissible')
                ));
            } else {
                $this->Flash->alert(__("The user's role could not be updated."), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-warning alert-dismissible')
                ));
            }
        }
        return $this->redirect(array('action' => 'view', $id));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return CakeResponse|null
     * @throws NotFoundException
     */
    public function delete($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete($id)) {
            $this->Flash->alert(__('The user account has been deleted.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-success alert-dismissible')
            ));
        } else {
            $this->Flash->alert(__('The account could not be deleted. Please, try again.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-warning alert-dismissible')
            ));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * Attempts to log a user into their account using the provided credentials.
     * @return CakeResponse|null
     */
    public function login() {
        if($this->request->is('post')) {
            if($this->Auth->login()) {
                $this->Flash->alert(__('Signed in successfully.'), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-success alert-dismissible')
                ));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->alert(__('Invalid username or password.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-danger alert-dismissible')
            ));
        }
    }

    /**
     * Logs the user out of their current session.
     *
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
        switch($action) {
            case "add":
            case "view":
                return true;
        }
        if(!isset($user)) return false;
        switch($action) {
            case 'delete':
                return $this->_isRequestedUser($user);
            case 'editrole':
                return $user['UserRole']['edit_user_role'];
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Checks if a user is the same as the requested user.
     * @param array $user The user to check.
     * @return boolean True if $user is the same as the user referenced in the current request.
     */
    protected function _isRequestedUser($user) {
        if(isset($this->request->params['pass'][0])) {
            $userId = $this->request->params['pass'][0];
            return $user['id'] === $userId;
        }
        return false;
    }
}
