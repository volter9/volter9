<p>
    Добро пожаловать! Меня зовут Евгений, но я также известен под ником volter9.
</p>

<p>
    В данном блоге я буду писать о веб технологиях (HTML/CSS, PHP, JS) и выкладывать 
    свои проекты на обозрение. Тут я буду писать разные туториалы, обзоры, идеи, 
    эксперименты и все что может быть связано с интернетом и веб технологиями.
</p>

<?php return [
    'projects' => array_slice($data->get('projects'), 0, 5),
    'posts'    => blog_posts($container, 5),
    'view'     => 'pages/index.jade'
]; 