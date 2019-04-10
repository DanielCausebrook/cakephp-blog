<?php


class Role extends AppModel {
    public $hasMany = array(
        'RoleUsers' => array(
            'className' => 'User',
            'foreignKey' => 'role_id'
        )
    );

    /**
     * Returns an array of all roles.
     * @return array|int|null
     */
    public function getAll() {
        return $this->find('all', array(
            'contain' => array()
        ));
    }

    /**
     * Retrieves the id of the role that is to be used as default (e.g. for new users).
     * @return integer
     */
    public function getDefaultId() {
        $role = $this->findByIsDefault(1);
        return $role[$this->alias]['id'];
    }
}
