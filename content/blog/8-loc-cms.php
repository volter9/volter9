Привет ребята!

PHP &mdash; такой мощный язык программирования на котором можно написать какой-угодно 
вебсайт, в зависимости от вашего опыта. 
Но ты, уважаемый читатель, даже не подозревал что на PHP можно написать 
собственную CMS всего лишь в 8 строк! 

Короче, PHP это самый крутой язык программирования на планете.

После прочтение этой научной статьи, ты получишь знание о том как создать свою
крутую CMS в 8 строк! 
Ну что же, давай начнем наше путешествие в удивительный мир <!-- психоделического --> PHP!

**UPD**: CMS из этой крутой статьи теперь на 
[GitHub](https://github.com/volter9/8-cms).

**Дисклеймер**: 8 строчек PHP кода. Контент, `.htaccess` конфиг, и шаблоны не 
идут в счет количества строчек. Только `index.php`, только ядро.

## CMS

<!-- Пожалуйста, не воспринимайте этот параграф всерьез, это же шутка :) -->
Наша CMS самая крутая и быстрая CMS на всей планете.
Качество PHP кода нашей CMS круче чем качество кода Линуса Тордавльса!

Давайте начнем с проектирования нашей крутой CMS в 8 строчек. 
Нам нужен план. Предлагаю такой план: 
<a href="http://macode.ru" target="_blank">просто написать код</a>. 
Отличный план.

Я вот написал:

```php
<?php echo '<?php ' ?> 

$route = trim(!empty($_GET['route']) ? $_GET['route'] : 'index', '/');

$file = "content/$route";
$file = file_exists("$file.php") ? "$file.php" : 'content/404.php';

ob_start();
$data = require $file;
$content = ob_get_clean();

extract($data ?: []);

include 'theme/layout.php';
```

<!-- А это правда -->
**Забавный факт**: данный блог начинался именно с этих строк.

Вот и вся наша CMS. В папке `theme` должны содержатся шаблоны CMS, 
а в папке `content` должен содержатся контент который должен возвращять массив 
с данными.

## Крутой пример сайта

Вот пример сайта (требует apache):

<div class="tabs-container full">
    <div class="tab">index.php</div>
    <div data-tab="index.php">
<?php ob_start() ?>
[?

$route = trim(!empty($_GET['route']) ? $_GET['route'] : 'index', '/');

$file = "content/$route";
$file = file_exists("$file.php") ? "$file.php" : 'content/404.php';

ob_start();
$data = require $file;
$content = ob_get_clean();

extract($data ?: []);

include 'theme/layout.php';
<?php echo code(ob_get_clean(), 'php') ?>
    </div>

    <div class="tab">.htaccess</div>
    <div data-tab=".htaccess">
<?php ob_start() ?>
AddDefaultCharset UTF-8

RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule (.*) index.php?route=$1 [QSA,L]
<?php echo code(ob_get_clean(), 'htaccess') ?>
    </div>
    
    <div class="tab">theme/index.php</div>
    <div data-tab="theme/index.php">
<?php ob_start() ?>
<!DOCTYPE html>
<html>
    <head>
        [? isset($title) and print($title) ?]
    </head>
    
    <body>
        <h1>
            [? isset($title) and print($title) ?]
        </h1>
        
        [? echo $content ?]
    </body>
</html>
<?php echo code(ob_get_clean(), 'html') ?> 
    </div>
    
    <div class="tab">content/index.php</div>
    <div data-tab="content/index.php">
<?php ob_start() ?>
<p>
    Добро пожаловать! 
    Мой сайт работает на самой крутой и быстрой CMS в мире, 
    которая написана в 8 строк кода.
</p>

[?

return [
    'title' => 'Добро пожаловать'
];
<?php echo code(ob_get_clean(), 'html') ?>
    </div>
    
    <div class="tab">content/404.php</div>
    <div data-tab="content/404.php">
<?php ob_start() ?>
<p>
    Вы наверное не на ту кнопку нажали. 
    По этому попали сюда. Или же потому что я удалил страницу, но не удалил
    внешнии ссылки.
</p>

[?

return [
    'title' => '404 - Страница не была найдена'
];
<?php echo code(ob_get_clean(), 'html') ?>
    </div>
</div>

Вот и вся CMS. В следующей части <!-- которая вряд ли будет опубликована -->, 
я <!-- не --> покажу как создать крутой форум для ДотА сервера на основе 
этой CMS.

## Купите курс

Вам понравился эта научная статья, и вы хотите научится писать такой же крутой код 
как я?

<!--               пограммированию -->
Ты хочешь научится программировать на PHP, познать самые крутые паттерны и Дзен PHP 
и грести деньги лопатой? Не пропусти этот редкий щанс получить золотую жилу 
знаний, купите наш курс и ты получишь все богатсво мира!!!

<!-- Нот реалли -->
<p style="text-align: center">
    <a class="buy-button" 
       href="javascript:alert('Хе-хе, шутка')" 
       title="Купишь сейчас, получишь скидку в 50%, лимитед оффер">
        Жми кнопку, купи курс!
    </a>
</p>

Также не забудь подписаться на наш канал на ютубе, вк паблик, инстаграм, гугл 
плюс, и твиттер аккаунты.

<style type="text/css">
    /**
     * Говно код, говнокод, 
     * единственный в мире CSS говнокод
     */
    .buy-button {
        background-color: hsl(40, 95%, 66%); 
        border: 0px !important; 
        border-radius: 8px;
        color: #000; 
        font-size: 24px; 
        font-weight: bold; 
        line-height: 140%;
        text-align: center;
        
        display: inline-block; 
        padding: 0.85em 2em; 
    }
    
    .buy-button:hover {
        background-color: hsl(40, 100%, 72%); 
    }
</style>

<?php return [
    'title'     => 'CMS в 8 строк!',
    'date'      => '09-10-2015 20:44:03',
    'category'  => 'PHP',
    'tags'      => ['прикол', 'flat file CMS'],
    'processor' => 'markdown'
];