<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php
    echo $this->Html->charset();
    echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'));
    ?>
	<title>
		<?php echo $cakeDescription; ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
<div class="container-fluid p-2">
    <header class="container-fluid p-0 mb-4 border rounded bg-dark text-light">
        <div class="row py-3 align-items-center">
            <div class="col-lg mx-3">
                <h1>CakePHP Blog</h1>
            </div>
            <?php if(AuthComponent::user('id')) { ?>
                <div class="col-auto p-1"><?= __("Signed in as %s.", h(AuthComponent::user('username'))) ?></div>
                <div class="col-auto mr-3">
                    <?= $this->Html->link(__('Sign Out'),
                        array('controller' => 'users', 'action' => 'logout'),
                        array('class' => 'btn btn-primary btn-sm')) ?>
                </div>
            <?php } else { ?>
                <div class="col-auto p-1"><?= __("Not signed in.") ?></div>
                <div class="col-auto mr-3">
                    <?= $this->Html->link(__('Login'),
                        array('controller' => 'users', 'action' => 'login'),
                        array('class' => 'btn btn-primary btn-sm')) ?>
                    <?= $this->Html->link(__('Register'),
                        array('controller' => 'users', 'action' => 'add'),
                        array('class' => 'btn btn-secondary btn-sm')) ?>
                </div>
            <?php } ?>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?= $this->Html->link('Posts',
                            array('controller' => 'posts', 'action' => 'index'),
                            array('class' => 'nav-link')) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Users',
                            array('controller' => 'users', 'action' => 'index'),
                            array('class' => 'nav-link')) ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="container-fluid m-1">
        <?php echo $this->Flash->render(); ?>
        <?= $this->fetch('content') ?>
    </section>
</div>
<footer class="container-fluid p-3 text-light bg-dark">
    Created by Daniel Causebrook
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
