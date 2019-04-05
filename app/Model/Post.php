<?php

class Post extends AppModel {
    public $validate = array(
        'title' => array(
            'rule' => 'notBlank'
        ),
        'body' => array(
            'rule' => 'notBlank'
        )
    );

    /**
     * Checks for and retrieves a post from the database.
     * @param null $id id of the post to retrieve.
     * @return mixed
     */
    public function getPost($id = null) {
        if(!$id) throw new NotFoundException(__('Invalid post'));

        $post = $this->findById($id);
        if(!$post) throw new NotFoundException(__('Invalid post'));
        return $post;
    }
}
