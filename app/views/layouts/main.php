<?php // app/views/layouts/main.php ?>
<?php 
// This layout is rendered by the Controller's render() method
// The $content variable contains the rendered view content
?>

<?php require_once __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/navbar.php'; ?>

<?php echo $content ?? ''; ?>

<?php require_once __DIR__ . '/footer.php'; ?>

