<?php
App::uses('User', 'Model');
App::uses('Role', 'Model');
class AppSchema extends CakeSchema {
    private $admin_role_id;
    private $rolesInit = false;
    private $usersInit = false;

	public function before($event = array()) {
		return true;
	}

    public function after($event = array()) {
        if (isset($event['create'])) {
            switch ($event['create']) {
                case 'roles':
                    App::uses('ClassRegistry', 'Utility');
                    $role = ClassRegistry::init('Role');
                    $role->create();
                    $role->save(array('Role' => array(
                        'name' => 'author',
                        'is_default' => true,
                        'add_post' => true
                    )));
                    $role->create();
                    $role->save(array('Role' => array(
                        'name' => 'mod',
                        'add_post' => true,
                        'edit_post' => true,
                        'delete_post' => true
                    )));
                    $role->create();
                    $role->save(array('Role' => array(
                        'name' => 'admin',
                        'add_post' => true,
                        'edit_post' => true,
                        'delete_post' => true,
                        'edit_user_role' => true
                    )));
                    $this->admin_role_id = $role->getInsertID();
                    $this->rolesInit = true;
                    if($this->usersInit) $this->addUser();
                    break;
                case 'users':
                    $this->usersInit = true;
                    if($this->rolesInit) $this->addUser();
                    break;
            }
        }
    }

    private function addUser() {
        App::uses('ClassRegistry', 'Utility');
        $user = ClassRegistry::init('User');
        $user->create();
        $user->save(array('User' => array(
            'username' => 'ChiefChef',
            'password' => 'password',
            'role_id' => $this->admin_role_id
        )));
    }

	public $posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'posts_users_id_fk' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

    public $users = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
        'username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'password' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'post_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
        'role_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'users_roles_id_fk' => array('column' => 'role_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'add_post' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'edit_post' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'delete_post' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'edit_user_role' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
