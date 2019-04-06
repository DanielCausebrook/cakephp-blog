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

    /**
     * Checks whether a user created a given post.
     * @param $id integer The ID of the user.
     * @param $userId integer The ID of the post.
     * @return bool True if the user created the post, false otherwise.
     */
    public function isOwnedBy($id, $userId) {
        return $this->field('id', array('id' => $id, 'user_id' => $userId)) !== false;
    }
}
