<article class="content full full-padding post">
    <h1 class="post-title">
        <?php echo $title ?> 
    </h1>
    
<?php echo $content ?> 

    <div class="fluid">
<?php echo $theme->partial('blocks/likely.php', ['title' => $title, 'classes' => 'likely-medium']) ?> 

        <ul class="post-details">
            <li class="post-date">
                <?php echo format_date($date) ?> 
            </li>
            <?php if (!empty($category)): ?> 
            <li>
                <span class="post-category post-<?php echo slugify($category) ?>-category">
                    <?php echo $category ?> 
                </span>
            </li>
            <?php endif; if (!empty($tags)): ?> 
            <li>
                <?php foreach ($tags as $index => $tag): ?> 
                <span class="post-tag"><?php echo $tag ?></span>
                <?php endforeach ?> 
            </li>
            <?php endif; ?> 
        </ul>
    </div>
    
<?php echo $theme->partial('blocks/comments.php') ?> 
</article>