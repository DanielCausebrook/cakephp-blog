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
    public $recursive = -1;

    /**
     * Checks for and retrieves a post from the database. Makes use of exceptions
     * @param null $id id of the post to retrieve.
     * @throws NotFoundException if the post is not found in the database.
     * @return array
     */
    public function getById($id = null) {
        if (!$id) throw new NotFoundException(__('Invalid %s.', $this->alias));

        $post = $this->findById($id);
        if (!$post) throw new NotFoundException(__('Invalid %s.', $this->alias));
        return $post;
    }
}
