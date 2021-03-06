<?php

class Post extends AppModel {
    public $belongsTo = array(
        'PostUser' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true
        )
    );
    public $validate = array(
        'title' => array(
            'rule' => 'notBlank'
        ),
        'body' => array(
            'rule' => 'notBlank'
        )
    );

    /**
     * Checks whether a user created a given post.
     * @param $id integer The ID of the user.
     * @param $userId integer The ID of the post.
     * @return bool True if the user created the post, false otherwise.
     */
    public function isOwnedBy($id, $userId) {
        return ($this->getById($id))['PostUser']['id'] === $userId;
    }
}
