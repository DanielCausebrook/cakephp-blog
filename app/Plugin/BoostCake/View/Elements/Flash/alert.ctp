<?php
if (isset($params['class'])) {
    $class = $params['class'];
}
if (!isset($class)) {
    $class = false;
}
if (!isset($close)) {
    $close = true;
}
?>
<div class="alert<?php echo ($class) ? ' ' . $class : null; ?>">
    <?php if ($close): ?>
        <button type="button" class="close" data-dismiss="alert">×</button>
    <?php endif; ?>
    <?php echo $message; ?>
</div>
