<?php $projects = isset($projects) ? $projects : $data->get('projects') ?>

<div class="clearfix full projects">
<?php foreach ($projects as $project): ?> 
    <div class="project left full">

<?php ob_start() ?>
<h2 class="project-title">
    <a href="<?php echo $url->make("projects/{$project['name']}") ?>">
        <?php echo $project['title'] ?> 
    </a>
</h2>

<p class="project-about">
    <?php echo $project['about'] ?> 
</p>
<?php $content = ob_get_clean() ?>
        
        <?php echo Bloge\render(
            basepath("content/_projects/{$project['name']}/banner.php"), 
            compact('content', 'theme', 'url')
        ) ?>
    </div>
<?php endforeach ?> 
</div>

<?php return [
    'title' => 'Проекты',
    'view'  => 'templates/full.php'
];