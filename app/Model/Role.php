<?php


class Role extends AppModel {
    public $hasMany = array(
        'RoleUsers' => array(
            'className' => 'User',
            'foreignKey' => 'role_id'
        )
    );

    public function getDefaultId() {
        $role = $this->findByIsDefault(1);
        return $role[$this->alias]['id'];
    }
}
