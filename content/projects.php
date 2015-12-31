<?php $projects = $data->get('projects') ?>

<div class="clearfix full projects">
<?php foreach ($projects as $project): ?> 
    <div class="project left full">
        <h2 class="project-title">
            <a href="<?php echo $url->make("projects/{$project['name']}") ?>">
                <?php echo $project['title'] ?> 
            </a>
        </h2>

        <p class="project-about">
            <?php echo $project['about'] ?> 
        </p>
    </div>
<?php endforeach ?> 
</div>

<?php return [
    'title' => 'Проекты',
    'view'  => 'templates/full.jade'
];