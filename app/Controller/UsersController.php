<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

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
        $this->User->recursive = 0;
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
        $user = $this->User->getById($id, array('UserPosts', 'UserRole'));

        $this->set('user', $user['User']);
        $this->set('posts', $user['UserPosts']);
        $this->set('role', $user['UserRole']);
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
     * edit method
     *
     * @param string $id
     * @return CakeResponse|null
     * @throws Exception
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->alert(__('The user has been saved.'), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-success alert-dismissible')
                ));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->alert(__('The user could not be saved. Please, try again.'), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-warning alert-dismissible')
                ));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
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
     *
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
}
