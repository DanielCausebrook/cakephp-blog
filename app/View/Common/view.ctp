<header>
    <h1>CakePHP Blog</h1>
    <div class="account">
        <?php if(AuthComponent::user('id')) { ?>
            <?= __("Signed in as %s.", h(AuthComponent::user('username'))) ?>
            <?= $this->Html->link(__('Sign Out'),
                array('controller' => 'users', 'action' => 'logout')) ?>
        <?php } else { ?>
            <?= __("Not signed in.") ?>
            <?= $this->Html->link(__('Login'),
                array('controller' => 'users', 'action' => 'login')) ?>
            <?= $this->Html->link(__('Register'),
                array('controller' => 'users', 'action' => 'add')) ?>
        <?php } ?>
    </div>
</header>
<nav>
    <?= $this->Html->link('Posts',
        array('controller' => 'posts', 'action' => 'index')) ?>
    <?= $this->Html->link('Users',
        array('controller' => 'users', 'action' => 'index')) ?>
</nav>
<section>
    <?= $this->fetch('content') ?>
</section>
<footer>
    Created by Daniel Causebrook
</footer>
