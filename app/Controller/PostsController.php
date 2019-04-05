<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    /**
     * View all posts
     */
    public function index() {
        $this->set('posts', $this->Post->find('all'));
    }

    /**
     * View one post
     * @param null $id id of the post to retrieve.
     */
    public function view($id = null) {
        $this->set('post', $this->Post->getPost($id));
    }

    /**
     * Add a new post
     * @return CakeResponse|null
     */
    public function add() {
        if($this->request->is('post')) {
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
}
