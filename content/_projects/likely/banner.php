<?php $url = $url->make('assets/uploads/likely/lights.jpg'); ?>

<div class="project-image" 
     style="background-size: cover; 
            background-image: url('<?php echo $url ?>');
            background-position: 0px 50%;">

<?php echo $content ?> 

    <div class="likely-separated">

<?php echo $theme->partial('blocks/likely.jade', ['classes' => 'likely-big likely-light']) ?> 
<?php echo $theme->partial('blocks/likely.jade', ['classes' => 'likely-light']) ?> 
<?php echo $theme->partial('blocks/likely.jade', ['classes' => 'likely-small likely-light']) ?> 

    </div>
</div>