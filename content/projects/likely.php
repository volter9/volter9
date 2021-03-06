<?php $_url = $url->make('assets/uploads/likely/lights.jpg'); ?>

<div class="text-shadow" style="background-size: cover; background-position: 0px 50%; background-image: url('<?php echo $_url ?>'); padding: 32px; margin-bottom: 1em; border-radius: 8px">
    <?php echo $theme->partial('blocks/likely.jade', ['classes' => 'likely-big likely-light']) ?> 
</div>

<a href="http://ilyabirman.ru/projects/likely" target="_blank">Лайкли</a> &mdash;
это красивые социокнопоки с счетчиками. Лайкли поддерживает шаринг страницы
в Фейсбуке, Твиттере, Вконтакте, Гугл плюсе, Пинтересте и Одноклассниках.
Оргинальный автор этого виджета является
<a href="http://ilyabirman.ru/" target="_blank">Илья Бирман</a>, 
а я являюсь со-автором проекта после портатирования Лайкли в 
<a href="http://vanilla-js.com/" target="_blank">ванильный JS</a> (дальше 
ванификация).

Тебя наверное интересует почему я ванилифицировал Лайкли? Хороший вопрос. 
Нам с Пашей нужен был виджет социокнопок для 
[Помидоркового Таймера](<?php echo $url->make('projects/pomidorko') ?>). Паша предложил 
Лайкли. Мне понравился Лайкли, но тащить jQuery ради Лайкли мне не хотелось.

Поэтому я решил ванилифицировать Лайкли.

## Ванилификация Лайкли

<abbr title="Портатирование jQuery кода в ванильный JS">Ванилификации</abbr> 
является достаточно простым но рутинным процессом. Процесс 
ванилификации Лайкли состоял из следующих пунктов:

1. Скачать и распаковать Лайкли <!-- "спасибо, кэп!" -->
2. Привести минифицированный код в читабельное состояние 
3. Разделить код на модули
4. Убрать весь jQuery код и заменить его на ванильный JS
<!-- 5. Get your shit together, man -->

Первый пункт я не собираюсь описывать, наверное сам знаешь почему.

### Читабельный код

Привести минифицированный код в читабельное состояние достаточно просто, если 
знаешь как работает минификатор JS кода вроде uglify-js.

Я написал [пост](<?php echo $url->make('blog/code-minification-techniques') ?>) о том
как работает минификатор в блоге. Чтобы привести минифицированный код в 
читабельный вид нужно было:

* Отформатировать код (я делал это с помощью этого 
<a href="http://jsbeautifier.org/" target="_blank">сервиса</a>)
* Разминифицировать код (как в посте 
["Техника минификации JS кода"](<?php echo $url->make('blog/code-minification-techniques') ?>) только в 
обратную сторону)
* Осмысленно перемименовать переменные и функции

Обе части оказались так себе по сложности, самое трудное было переименование 
переменных и функций. Сначала я переименовывал на основе своих догадок что 
делает код (а это не очень просто понять). Но потом мне надоело, поэтому я решил 
оставшуюся часть подсмотреть у 
<a href="http://github.com/social-likes/" target="_blank">оригинального плагина</a>. 

### Модули

После того как я привел код в порядок, можно было поместить код в отдельные 
модули. Почему я решил поместить код в отдельные модули? Хороший вопрос.
Большие файлы это мое ограничение. Мне легче контролировать и ориентироватся в 
огромном кол-во маленьких файлах (до 200 строк), даже если сумма строк в файлах
больше чем было все это в одном файле.

Модульный код чище, легче поддерживается, а также позволяет разработчам 
пользоваться модулями для построения своих социнокнопкок с бледжеком и 
счетчиками.

### Ванилификация jQuery кода

Ванилифицировать jQuery код это просто, если знаешь jQuery и ванильный DOM API, 
и как обе API работают. Ну а дальше простая конвертация кода по функционалу. 
Есть полезный ресурс по 
[ванилификации определенных jQuery функций](http://youmightnotneedjquery.com/).

Самое интересное в ванилификации jQuery кода было замена $.Deferred объекта. 
В оригинальном плагине, $.Deferred использовался для асинхронной загрузки 
счетчиков. В принципе, $.Deferred для загрузки счетчиков был оверкиллом. 
Часть кода которая отвечала за загрузку счетчика использовала не весь потенциал 
$.Deferred API. 

Social Likes и Лайкли использовали $.Deferred только для `.always()`, поэтому 
вместо аналога $.Deferred я решил написать что то вроде `ko.observable()`:

```js
/**
 * Factory function
 * 
 * This function returns function with following API:
 * 
 * - if passed argument is callback, then this callback would be callled
 *   if the value was changed
 * - if passed argument is anything but undefined or function, then this 
 *   function behaves like setter
 * - if argument isn't provided, then return value stored in closure
 * 
 * @param {Object} value
 * @return {Function}
 */
module.exports = function (value) {
    var listeners = [];
    
    return function (argument) {
        var type = typeof argument;
        
        if (type == 'undefined') {
            return value;
        }
        else if (type == 'function') {
            listeners.push(argument);
        }
        else {
            value = argument;
            
            listeners.forEach(function (listener) {
                listener(argument);
            });
        }
    };
};
```

<?php

return [
    'title'  => 'Лайкли',
    'name'   => 'likely',
    'view'   => 'templates/project.jade',
    'layout' => 'layouts/project.jade',
    'processor' => 'markdown'
];