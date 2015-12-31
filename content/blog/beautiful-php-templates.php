<?php
    $links = [
        ['/', 'Главная'],
        ['/blog', 'Блог'],
        ['/contact', 'Контакты']
    ];
?>
Привет, данный пост посвящен перфекционистам как я. Бывало у тебя такое что 
когда пишешь PHP/Twig шаблоны в итоге вывод получается что-то вроде такого?:

<?php ob_start() ?>
<!-- blocks/navigation -->
<nav class="navigation">
    <ul>
        <?php foreach ($links as $link): ?>
        <li>
            <a href="<?php echo $link[0] ?>">
            <?php echo $link[1] ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php echo code(ob_get_clean(), 'html') ?>

Этот вывод... это же _некрасиво_. PHP шаблон имеет такое содержание:

<?php ob_start() ?>
<!-- blocks/navigation -->
<nav class="navigation">
    <ul>
        [? foreach ($links as $link): ?]
        <li>
            <a href="[? echo $link[0] ?]">
            [? echo $link[1] ?]
            </a>
        </li>
        [? endforeach; ?]
    </ul>
</nav>
<?php echo code(ob_get_clean(), 'html') ?>

Да к в чем же проблема? Почему PHP просто не может вывести так как есть в 
шаблонах? Что же происходит там в недрах PHP что приводит к искажению 
форматирования? Ответ очень прост:

Закрывающиеся PHP тэги (`?>`) удаляют один перенос строки (`\n`) в итоге 
форматирование шаблонов обрывается. Чтобы предотвратить данную проблему все что 
нужно сделать это добавить после каждого `?>` пробел.

<?php ob_start() ?>
<!-- blocks/navigation -->
<nav class="navigation">
    <ul>
        <!-- Так намного лучше -->
        <?php foreach ($links as $link): ?> 
        <li>
            <a href="<?php echo $link[0] ?>">
            <?php echo $link[1] ?> 
            </a>
        </li>
        <?php endforeach; ?> 
    </ul>
</nav>
<?php echo code(ob_get_clean(), 'html') ?>

Вот так то лучше! Это вывод того же самого PHP шаблона, только после каждого 
закрывающегося PHP тэга добавлен пробел.

### Вывод

К сожалению, нельзя добится полного контроля над форматированием вывода 
PHP шаблонов без потери форматирования в исходном коде.

<?php return [
    'title'     => 'Красивые PHP шаблоны',
    'date'      => '27-10-2015 07:03:35',
    'tags'      => ['верстка', 'HTML', 'форматирование'],
    'category'  => 'PHP',
    'processor' => 'markdown'
];