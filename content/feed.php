<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" 
     xmlns:atom="http://www.w3.org/2005/Atom" 
     xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>volter9.github.io</title>
        <description>Личный блог volter9</description>
        <link>http://volter9.github.io</link>
        
        <atom:link href="<?php echo $url->makeFull('feed') ?>" 
                   rel="self" 
                   type="application/rss+xml"/>
        
        <?php foreach (blog_posts($content, 10) as $post): 
            $full_url = $url->makeFull("blog/{$post['route']}");
        ?> 
        <item>
            <title><?php echo $post['title'] ?></title>
            
            <link><?php echo $full_url ?></link>
            <guid isPermaLink="true"><?php echo $full_url ?></guid>
            
            <description>
                <?php echo htmlspecialchars($post['content'], ENT_XML1, 'UTF-8') ?>
            </description>
            <pubDate>
                <?php echo date('r', strtotime($post['date'])) ?>
            </pubDate>
        </item>
        <?php endforeach ?> 
    </channel>
</rss>
<?php return ['layout' => 'layouts/blank.php'];