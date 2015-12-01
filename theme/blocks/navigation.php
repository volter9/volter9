<?php $classes = isset($classes) ? " $classes" : ''; ?>
<nav class="fluid navigation<?php echo $classes ?>">
    <ul class="clearfix links">
    <?php foreach ($data->get('navigation') as $item): ?> 
        <li class="left">
            <a class="<?php echo $url->isCurrent($item['url'], $route) ? 'current' : '' ?>" 
               href="<?php echo $url->make($item['url']) ?>">
                <?php echo $item['title'] ?> 
            </a>
        </li>
    <?php endforeach ?> 
    </ul>
</nav>