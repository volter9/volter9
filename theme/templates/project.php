<?php echo Bloge\render(basepath("content/_projects/$name/header.php"), $__data__) ?>

<article class="content full full-padding post">
<?php echo $content ?> 
    
<?php echo $theme->partial('blocks/likely.php', compact('title')) ?> 
</article>