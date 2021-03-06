<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $belongsTo = array(
        'UserRole' => array(
            'className' => 'Role',
            'foreignKey' => 'role_id'
        )
    );
    public $hasMany = array(
        'UserPosts' => array(
            'className' => 'Post',
            'foreignKey' => 'user_id'
        )
    );
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A username is required'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'An account with this username already exists'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A password is required'
            )
        )
    );

    /**
     * Checks that a password correctly matches a user's stored hash.
     * @param $password string The password to check.
     * @param $user array The user to check against.
     * @return bool True if the hashes match.
     */
    public function checkPassword($password, $user) {
        $passwordHasher = new BlowfishPasswordHasher();
        return $passwordHasher->check($password, $user['User']['password']);
    }

    public function beforeSave($options = array()) {
        // Hash password.
        if(isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }

        // If role is unset, set to default.
        if(!isset($this->data[$this->alias]['role_id'])) {
            $this->data[$this->alias]['role_id'] = $this->UserRole->getDefaultId();
        }

        return true;
    }
}
