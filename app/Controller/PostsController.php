<?php

class PostsController extends AppController {
    public $helpers = array(
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Flash');
    public $components = array('Flash');

    /**
     * View all posts.
     */
    public function index() {
        $this->set('posts', $this->Post->find('all', array(
            'order' => array('Post.modified' => 'desc'),
            'contains' => 'PostUser'
        )));
        $this->set('canAdd', $this->_isActionAuthorized($this->Auth->user(), 'add'));
    }

    /**
     * View one post.
     * @param null $id id of the post to retrieve.
     */
    public function view($id = null) {
        $this->helpers[] = 'Markdown';
        $post = $this->Post->getById($id, array('PostUser'));
        $isPostOwner = $post['Post']['user_id'] === $this->Auth->user('id');
        $this->set('post', $post['Post']);
        $this->set('author', $post['PostUser']);
        $this->set('canEdit', $this->_isActionAuthorized($this->Auth->user(), 'edit', $isPostOwner));
        $this->set('canDelete', $this->_isActionAuthorized($this->Auth->user(), 'delete', $isPostOwner));
    }

    /**
     * Add a new post.
     * @return CakeResponse|null
     */
    public function add() {
        if($this->request->is('post')) {
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');

            $this->Post->create();
            if($this->Post->save($this->request->data)) {
                return $this->redirect(array('action' => 'view', $this->Post->getInsertID()));
            }
            $this->Flash->error(__('Unable to save your post.'));
        }
    }

    /**
     * Edit an existing post.
     * @param null $id id of the post to edit.
     * @return CakeResponse|null
     */
    public function edit($id = null) {
        $post = $this->Post->getById($id);

        if($this->request->is(array('post' => 'put'))) {
            $this->Post->id = $id;
            if($this->Post->save($this->request->data)) {
                $this->Flash->success(__("The post has been updated!"));
                return $this->redirect(array('action' => 'view', $id));
            }
            $this->Flash->error(__('Unable to update the post.'));
        }

        if(!$this->request->data) {
            $this->request->data = $post;
        }
    }

    /**
     * Delete an existing post.
     * @param null $id id of the post to delete.
     * @return CakeResponse|null
     */
    public function delete($id = null) {
        $this->request->allowMethod('post', 'delete');

        if($this->Post->delete($id)) {
            $this->Flash->success(__('The post was deleted.'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->error(__('The post could not be deleted.'));
            return $this->redirect(array('action' => 'view', $id));
        }
    }

    public function isAuthorized($user) {
        return $this->_isActionAuthorized($user, $this->action, $this->_isPostOwner($user));
    }

    /**
     * Checks if any action is authorised for a given user.
     * @param array $user The user attempting the action.
     * @param string $action The action being attempted, as reported by $this->action. e.g. 'index'
     * @param bool $isPostOwner Whether the user owns the post on which the action is being attempted, if applicable.
     * @return bool True if the action is authorised, false otherwise.
     */
    protected function _isActionAuthorized($user, $action, $isPostOwner = false) {
        if(!isset($user)) return false;
        switch ($action) {
            case "add":
                return $user['UserRole']['add_post'];
            case "edit":
                return $user['UserRole']['edit_post'] || $isPostOwner;
            case "delete":
                return $user['UserRole']['delete_post'] || $isPostOwner;
            default:
                return false;
        }
    }

    /**
     * Checks if a user owns the requested post.
     * @param $user
     * @return boolean
     */
    protected function _isPostOwner($user) {
        if(isset($this->request->params['pass'][0])) {
            $postId = $this->request->params['pass'][0];
            return $this->Post->isOwnedBy($postId, $user['id']);
        }
        return false;
    }
}
