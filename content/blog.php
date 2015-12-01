<ul class="posts">
<?php foreach (blog_posts($content, isset($limit) ? $limit : 0) as $data): ?> 
    <li>
        <a href="<?php echo $url->make($data['route']) ?>">
            <?php echo $data['title'] ?> 
        </a>
    </li>
<?php endforeach; ?> 
</ul>

<?php return [
    'title' => 'Блог',
    'view'  => 'templates/default.php'
];