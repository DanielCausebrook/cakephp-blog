<div class="row alert-fixed-outer justify-content-center">
    <div class="col-auto">
        <div id="<?php echo $key; ?>Message" class="alert alert-success alert-dismissible <?php echo !empty($params['class']) ? $params['class'] : 'message'; ?>">
            <?php
            echo $message;
            if(!isset($params['close']) || $params['close']) { ?>
                <button type="button" class="close" data-dismiss="alert">×</button>
            <?php } ?>
        </div>
    </div>
</div>
