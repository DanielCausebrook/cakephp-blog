<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    /**
     * View all posts
     */
    public function index() {
        $this->set('posts', $this->Post->find('all', array('contains' => 'PostUser')));
    }

    /**
     * View one post
     * @param null $id id of the post to retrieve.
     */
    public function view($id = null) {
        $post = $this->Post->getById($id, array('PostUser'));
        $isPostOwner = $post['Post']['user_id'] === $this->Auth->user('id');
        $this->set('post', $post['Post']);
        $this->set('author', $post['PostUser']);
        $this->set('canEdit', $this->isActionAuthorized($this->Auth->user(), $isPostOwner, 'edit'));
        $this->set('canDelete', $this->isActionAuthorized($this->Auth->user(), $isPostOwner, 'delete'));
    }

    /**
     * Add a new post
     * @return CakeResponse|null
     */
    public function add() {
        if($this->request->is('post')) {
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');

            $this->Post->create();
            if($this->Post->save($this->request->data)) {
                $this->Flash->alert(__("Your post has been saved!"), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-success alert-dismissible')
                ));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->alert(__('Unable to save your post.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-danger alert-dismissible')
            ));
        }
    }

    /**
     * Edit an existing post
     * @param null $id id of the post to edit.
     * @return CakeResponse|null
     */
    public function edit($id = null) {
        $post = $this->Post->getById($id);

        if($this->request->is(array('post' => 'put'))) {
            $this->Post->id = $id;
            if($this->Post->save($this->request->data)) {
                $this->Flash->alert(__("Your post has been updated!"), array(
                    'plugin' => 'BoostCake',
                    'params' => array('class' => 'alert-success alert-dismissible')
                ));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->alert(__('Unable to update your post.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-danger alert-dismissible')
            ));
        }

        if(!$this->request->data) {
            $this->request->data = $post;
        }
    }

    /**
     * Delete an existing post
     * @param null $id id of the post to delete.
     * @return CakeResponse|null
     */
    public function delete($id = null) {
        if($this->request->is('get')) throw new MethodNotAllowedException();

        if($this->Post->delete($id)) {
            $this->Flash->alert(__('Your post was deleted.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-success alert-dismissible')
            ));
        } else {
            $this->Flash->alert(__('Your post could not be deleted.'), array(
                'plugin' => 'BoostCake',
                'params' => array('class' => 'alert-warning alert-dismissible')
            ));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function isAuthorized($user) {
        return $this->isActionAuthorized($user, $this->isPostOwner($user), $this->action);
    }

    public function isActionAuthorized($user, $isPostOwner, $action) {
        switch($action) {
            case "add":
                return $user['UserRole']['add_post'];
            case "edit":
                return $user['UserRole']['edit_post'] || $isPostOwner;
            case "delete":
                return $user['UserRole']['delete_post'] || $isPostOwner;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Checks if a user owns the requested post.
     * @param $user
     * @return boolean
     */
    public function isPostOwner($user) {
        if(isset($this->request->params['pass'][0])) {
            $postId = $this->request->params['pass'][0];
            return $this->Post->isOwnedBy($postId, $user['id']);
        }
        return false;
    }
}
