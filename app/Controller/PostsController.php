<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    /**
     * View all posts
     */
    public function index() {
        $this->set('posts', $this->Post->find('all'));
        if($this->Auth->user('id')) {
            $this->set('loggedIn', true);
        }
    }

    /**
     * View one post
     * @param null $id id of the post to retrieve.
     */
    public function view($id = null) {
        $this->set('post', $this->Post->getPost($id));
        $this->set('canEdit', $this->canEdit($this->Auth->user()));
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
                $this->Flash->success(__("Your post has been saved!"));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to save your post.'));
        }
    }

    /**
     * Edit an existing post
     * @param null $id id of the post to edit.
     * @return CakeResponse|null
     */
    public function edit($id = null) {
        $post = $this->Post->getPost($id);

        if($this->request->is(array('post' => 'put'))) {
            $this->Post->id = $id;
            if($this->Post->save($this->request->data)) {
                $this->Flash->success(__("Your post has been updated!"));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
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
            $this->Flash->success(__('Your post was deleted.'));
        } else {
            $this->Flash->error(__('Your post could not be deleted.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function isAuthorized($user) {
        // Any user may create posts.
        switch($this->action) {
            case "add":
                return true;
            case "edit":
            case "delete":
                return $this->canEdit($user);
            default:
                return parent::isAuthorized($user);
        }
    }

    /**
     * Checks if a user has the authorization to edit or delete the current post.
     * @param $user array The user to check.
     * @return bool True if the user has permission, false otherwise.
     */
    public function canEdit($user) {
        if(isset($user['role'])) {
            $postId = $this->request->params['pass'][0];
            $isOwner = $this->Post->isOwnedBy($postId, $user['id']);
            switch($user['role']) {
                case 'author':
                    return $isOwner;
                case 'moderator':
                case 'admin':
                    return true;
                default:
                    return false;
            }
        }
        return false;
    }
}
