<?php $url = $url->make('assets/uploads/likely/lights.jpg'); ?>

<div class="epic-header full"
     style="background-size: cover; 
            background-position: 0px 50%;
            background-image: url('<?php echo $url ?>');">

<?php echo $theme->partial('blocks/navigation.jade', array_merge($__data__, [
    'classes' => 'navigation-white navigation-shadow'
])) ?> 
    
    <div class="fluid">
        <h1 class="epic-header-title text-shadow">
            <?php echo $title ?> 
        </h1>
    </div>
    
    <div class="fluid text-shadow" style="margin: 1em 0px 2em 0px">

<?php echo $theme->partial('blocks/likely.jade', ['classes' => 'likely-big likely-light']) ?> 

    </div>
</div>