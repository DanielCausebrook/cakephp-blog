<?php
$this->assign('title', 'Error');
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row mt-3 mb-5 align-items-center text-center border-bottom border-danger-light">
            <h1 class="col p-2"><?= __('Something went wrong!') ?></h1>
        </div>
        <p class="text-center"><?= __('Sorry! We encountered an unexpected error whilst processing your request.') ?></p>
        <div class="row m-3 mt-5 p-3 pt-4 border border-danger-light rounded bg-danger-light align-items-baseline justify-content-md-center text-danger">
            <div class="col-sm-auto mx-3 h5">
                Details:
            </div>
            <div class="col-md-auto text-monospace">
                <?php echo $message; ?>
            </div>
            <div class="w-100"></div>
            <div class="col-md-auto mt-3 pt-3 border-top border-danger-light">
                <?php
                if (Configure::read('debug') > 0):
                    echo $this->element('exception_stack_trace');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
