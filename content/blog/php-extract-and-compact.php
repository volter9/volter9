В этом посте я расскажу о двух очень полезных функциях которыми я очень часто 
пользуюсь и о которых, наверное, мало кто знает или считает плохой практикой. 

Для начала я скажу что управление областью видимости не является плохой вещью. 
По моему мнению, нету плохого и хорошего в программирование. Есть просто разные 
инструменты и техники для решение определенных задач.

**Внимание**: в параграфе выше я не утверждаю что нужно пользоватся только 
синглетонами, глобальными переменными и `goto`. Каждый решает для 
себя какую технику использовать и имеет право на мнение против/за разные практики.

Теперь перейдем к самому интересному, самим функциям `extract` и `compact`.

## extract

[extract](http://php.net/manual/en/function.extract.php) функция распаковывает 
значение из ассоциативного массива в данную область видимости. Аналогичный код 
который делает тоже самое что и extract с одним аргументом в виде массива:

```php
foreach ($assoc_array as $key => $value) {
    $$key = $value;
}

// vs.

extract($assos_array);
```

Данная функция полезна для следующих задач:

* Распаковка переменных в шаблонах в кастомном шаблонизаторе на основе PHP/своего 
  синтаксиса
* Распаковка переменных для облегчения обращение к ключам ассоциативного массива
  `$config['abc']` → `$abc` (но тут нужно точно знать какие ключи существуют)
* Пседо-эмуляция Python `**kwargs` в PHP

Пример использования:

<div class="tabs-container full">
    <div class="tab">index.php</div>
    <div data-tab="index.php">
<?php ob_start() ?>
[?

/**
 * __ нужны для предотвращения перезаписи переменных
 * 
 * @param string $__view__
 * @param array $__data__
 */
function render ($__view__, $__data__) {
    extract($__data__);
    
    require($__view__);
}

$title = 'Привет мир!';
$text  = 'Длинный текст...';

render('theme/view.php', [
    'title' => $title,
    'text'  => $text
]);
<?php echo code(ob_get_clean(), 'php') ?> 
    </div>
    
    <div class="tab">theme/view.php</div>
    <div data-tab="theme/view.php">
<?php ob_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>[? echo $title ?]</title>
    </head>
    
    <body>
        <h1>
            [? echo $title ?] 
        </h1>

        <p>
            [? echo $text ?]
        </p>
    </body>
</html>
<?php echo code(ob_get_clean(), 'html') ?> 
    </div>
</div>

Я уверен что есть еще применение этой функции, но только их пока что не знаю.

## compact

[compact](http://php.net/manual/en/function.compact.php) функция является 
противоположностью функции extract. Данная функция запаковывает массив ключей 
или названия переменных, разделенные через запятые, в ассоциативный массив, где 
название переменной станет ключем, а значение значением в массиве.

Эта функция будет полезна в следующих случаях:

* Передать из контролера переменные в представление (MVC)
* Вернуть из функции значения переменных в виде массива

Предыдущий пример можно упростить (укоротить) за счет использования compact:

<?php ob_start() ?>
[?

/**
 * __ нужны для предотвращения перезаписи переменных
 * 
 * @param string $__view__
 * @param array $__data__
 */
function render ($__view__, $__data__) {
    extract($__data__);
    
    require($__view__);
}

$title = 'Привет мир!';
$text  = 'Длинный текст...';

render('theme/view.php', compact('title', 'text'));
<?php echo code(ob_get_clean(), 'php') ?> 

Эти функции очень полезны для работы с переменными в данной области видимости. 
Используйте их там где они нужны. В любом случае, пример был усложнен для 
того чтобы показать как работает `extract` и `compact`. Первый пример можно 
упростить до:

<?php ob_start() ?>
[?

$title = 'Привет мир!';
$text  = 'Длинный текст...';

require 'theme/view.php';
<?php echo code(ob_get_clean(), 'php') ?> 

Всем хорошего дня/вечера!

<?php return [
    'title'     => 'extract и compact',
    'date'      => '03-11-2015 20:40:06',
    'category'  => 'PHP',
    'tags'      => ['область видимости', 'extract', 'compact', 'массивы', 'трюки'],
    'processor' => 'markdown'
];