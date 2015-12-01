<!DOCTYPE html>
<html>
    <head>
<?php echo $theme->partial('blocks/head.php') ?> 
    </head>

    <body>
        <div class="wrapper">
<?php echo $theme->partial('blocks/navigation.php') ?> 
<?php echo $theme->partial($view) ?> 

<?php echo $theme->partial('blocks/footer.php') ?> 
<?php echo $theme->partial('blocks/metrika.php') ?>
        </div>
    </body>
</html>