<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public $actsAs = array('Containable');
    public $recursive = 1;

    /**
     * Checks for and retrieves a post from the database. Makes use of exceptions instead of inconsistent return types.
     * @param null $id id of the post to retrieve.
     * @param array $contains The associated models to fetch.
     * @return array
     */
    public function getById($id = null, $contains = array()) {
        if (!$id) throw new NotFoundException(__('Invalid %s.', $this->alias));

        $post = $this->find('first', array(
            'contains' => $contains,
            'conditions' => array($this->alias.'.id' => $id)
        ));
        if (!$post) throw new NotFoundException(__('Invalid %s.', $this->alias));
        return $post;
    }

    /**
     * Checks for and retrieves a post from the database. Makes use of exceptions instead of inconsistent return types.
     * @param null $id id of the post to retrieve.
     * @param array $contains The associated models to fetch.
     * @return array
     */
    public function getAllById($id = null, $contains = array()) {
        if (!$id) throw new NotFoundException(__('Invalid %s.', $this->alias));

        $post = $this->find('all', array(
            'contains' => $contains,
            'conditions' => array($this->alias.'.id' => $id)
        ));
        if (!$post) throw new NotFoundException(__('Invalid %s.', $this->alias));
        return $post;
    }
}
