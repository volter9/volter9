<?php

/**
 * Index page
 */

$hello = $content->fetch('blog/hello-world');

$post = $hello['content'];
$post = mb_substr($post, 0, mb_strpos($post, '<h2>')); ?>

<!-- Обо мне -->
<div class="about-me full">
    <div class="fluid clearfix">        
        <div class="about-me-text left">
            <h2>Немножко обо мне</h2>

<?php echo $post ?> 
<!-- А также я люблю дразнить дизайнеров таким расположением блока :P -->
            
            <div class="columns-2 clearfix">
                <!-- Блог -->
                <div class="blog left">
                    <h3>Последнии записи</h3>

<?php echo Bloge\render(
    basepath('content/blog.php'), 
    ['content' => $content, 'limit' => 5, 'url' => $url]
) ?> 
                </div>
                
                <!-- Проекты -->
                <div class="blog left">
                    <h3>Проекты</h3>
                
                    <ul style="margin: 0px">
                    <?php foreach (array_slice($data->get('projects'), 0, 5) as $project): ?> 
                        <li>
                            <a href="<?php echo $url->make('projects/' . $project['name']) ?>">
                                <?php echo $project['title'] ?>
                            </a>
                        </li>
                    <?php endforeach ?> 
                    </ul>
                </div>
            </div>

<?php echo $theme->partial('blocks/likely.jade', ['content' => $content, 'limit' => 5, 'url' => $url]) ?>
        </div>
    </div>
</div>

<?php return [
    'title' => '', 
    'view' => 'templates/custom.jade'
]; 