<p>
    Тут я собираю разные ссылки которые мне понравились, показались интересными, 
    насмешили, являются очень полезными или просто так, для коллекции. 
</p>

<ul>
<?php foreach ($data->get('links') as $link => $title): ?> 
    <li>
        <a href="<?php echo $link ?>">
            <?php echo $title ?> 
        </a>
    </li>
<?php endforeach ?> 
</ul>

<p>
    Ты сам нашел какую нибудь интересную ссылку? Можешь написать в комментариях
    ниже, я уверен, это может кому то пригодится.
</p>

<?php echo $theme->partial('blocks/likely.php') ?> 
<?php echo $theme->partial('blocks/comments.php', compact('route')) ?> 

<?php

return [
    'title' => 'Ссылки',
    'view'  => 'templates/full.php'
];