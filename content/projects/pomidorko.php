<a href="http://pomidorko.ru/" target="_blank">Помидорковый таймер</a> &mdash; 
это инструмент для управления времени с помощью технике «Помодоро». Суть данной 
техники это распределенние времени таким образом чтобы перенагружать мозг, 
давая себе и мозгу сделать небольшой перерыв. 

<div id="pomidorko" style="margin-bottom: 1em">
    <div class="pa-skip">
        <span>Пропустить</span>
    </div>
    
    <div class="pa-timer clearfix">
        <div class="pa-left-block">
            <div class="pa-timer-time">
                <span class="pa-min">00</span>
                <span class="pa-colon">:</span>
                <span class="pa-sec">00</span>
            </div>
        </div>
        
        <div class="pa-timer-scale pa-right-block">
            <div class="pa-timer-wrapper">
                <img srcset="<?php echo $url->make('assets/uploads/pomidorko/img/scale@2x.png') ?> 2x"
                     src="<?php echo $url->make('assets/uploads/pomidorko/img/scale.png') ?>"
                     alt="Шкала времени">
            </div>
        </div>
    </div>
    
    <div class="pa-timer-control pa-play">
        <span class="pa-icon pa-play"></span>
    </div>
</div>

<a href="http://omelekhin.ru" target="_target">Паша Омелёхин</a> и я создали
этот таймер. Помидорковый таймер также доступен на
<a href="http://pomidorko.com/" target="_blank">Английском</a>.
Также мы планируем разработать таймер для OS X, iOS и watchOS.

Инструкция по эксплутации таймера:

1. Выберите задачу и работайте над ней 25 минут, ни на что не отвлекаясь.
1. Сделайте небольшой перерыв, заварите чаю, можно скушать банан.
1. Каждый четвертый перерыв отдыхайте дольше, мозгу нужно восстановиться.

## Инструменты

В данном проекте я использовал данные ~~костыли~~ инструменты:

* make — автоматизация сбора проекта и деплоя
* JS, Browerify и uglify-js — фронт-енд
* PHP — сборка локализированных HTML шаблонов
* ncftp — деплой на FTP сервер

## JS и Browerify

Основная часть кода написана на JS. Код распределен во множество require модулей 
и собирается посредством browserify. JS код состоит из: компонентов, хелперов и моделей.

### Компоненты

Компоненты принимают DOM узел и объекты на которые можно повесить события, вроде
моделей и таймера. У каждого компонента имеется обязтаельный activate метод который 
запускает компонент (привязывает события к таймеру/модели и отображает/меняет 
состояние модели).

Вот пример компонента который меняет Favicon в зависимости от состояния таймера 
(перерыв/работа):

<?php ob_start() ?>
var Component = require('./component');

module.exports = Component.extend({
    /**
     * @param {Node} link
     * @param {pomidorko.Timer} timer
     * @param {mvc.Model} goals
     */
    constructor: function (link, timer, goals) {
        this.link = link;
        this.timer = timer;
        this.goals = goals;
    },
    
    activate: function () {
        this.timer.on('stop', this.change.bind(this));
        
        this.change();
    },
    
    change: function () {
        var icon = this.goals.get('recess') ? 'break.ico' : 'work.ico';
        
        this.link.href = 'assets/img/' + icon;
    }
});
<?php echo code(ob_get_clean(), 'js', 'big') ?> 

Организуя весь код в модулях, изолирует отдельный функционал от остального кода
и обязывает данный код в модуле иметь одну обязанность, тем самым делая код 
более чище и модульным. Но не весь код что помещен в модули является модульным.

Полная версия таймера использует все 14 компонентов, в то время как данные 
компоненты можно использовать по отдельности (как у меня 
<a href="http://volter9.github.io/projects/pomidorko/">на сайте в шапке</a>).

С поверхности, это не выглядит очень полезным, зато в таком коде легче искать 
баги (если они не связаны с челочкой событий).

### Все остальное

В помидорке используются базовые хелперы: обертка над localStorage, события, 
расширения прототипов (.extend), dom, массивы/объекты, и т.д. В общем все хелперы 
это просто функция или namespace (объект) с функциями для упрощения кода.

Модели в помидорке — это "класс" который расширен для работы с событиями через 
mixin и содержит в себе данные которые можно получить/установить через get/set 
методы. При использования set метода срабатывает 'change' событие, с помощью 
этого события можно узнать когда изменилось общее состояние модели. Таким 
образом, очень просто привязать слушатель события и отобразить что-нибудь 
опираясь на это состояние.

### Bootstrap

Чтобы запустить помидорковый таймер нужно создать poimdorko.Timer, получить 
модели из localStorage или дефолтные значения, заполнить языковой конфиг, 
создать компоненты/сервисы и активировать все компоненты, в общем bootstrap 
код таймера:

<?php ob_start() ?>
var components = pomidorko.components,
    dom        = pomidorko.dom;

/* reset() - отвечает за сброс goals после 6 часов утра */
pomidorko.bootstrap.reset();

var container = dom.find('#pomidorka'),
    timer     = new pomidorko.Timer,
    data      = pomidorko.bootstrap(pomidorko.config);

var settings = data.settings,
    goals    = data.goals;

pomidorko.lang.set({ /* Объект с локализированными строками */ });

var services = [
    new components.PlayPause(dom.find('.pa-timer-control'), timer),
    new components.State(container, timer, goals, settings),
    new components.Scale(dom.find('.pa-timer-wrapper'), timer),
    new components.Time(dom.find('.pa-timer-time'), timer),
    new components.Skip(dom.find('.pa-skip'), timer, goals),
    new components.Goals(dom.find('.pa-goals'), goals, settings),
    new components.TickTock(
        timer, settings, new Audio('assets/sounds/tick.mp3')
    ),
    new components.Sound(
        timer, settings, new Audio('assets/sounds/bell.mp3')
    ),
    new components.About(
        dom.find('.pa-about-button'), dom.find('.pa-about')
    ),
    new components.Favicon(dom.find('[rel=icon]'), timer, goals),
    new components.Title(timer, goals),
    new components.Notifications(timer, goals, settings),
    new components.Settings(
        dom.find('.pa-settings-button'), 
        dom.find('.pa-settings'), settings
    ),
    new components.Save(timer, goals)
];

services.forEach(function (service) {
    service.activate();
});
<?php echo code(ob_get_clean(), 'js', 'big') ?> 

Ну и конечно же нужно до этого загрузить HTML.

## PHP

PHP в данном проекте служит как простой сборщик локализированных шаблонов. Там 
особо ничего интересного, просто что-то вроде:

```php
ob_start(); 

require $file; 

file_put_contents("build/$lang.html", ob_get_clean());
```

## ncftp

ncftp нужен для деплоя помидрокового таймера на сервер через FTP. Ручками каждый 
раз заливать все файлы через filezilla не очень удобно, а git'a на хостинге нету, 
поэтому приходится придумывать вот такие скрипты:

<?php ob_start() ?>
#!/bin/sh

# FTP deploy script
source ./ftp.sh

# Variables
DOMAIN="$1"
LANG="$2"
FILES=$(git diff --name-only HEAD~1 HEAD)

if [ "$3" == "true" ]
then
    FILES=$(git ls-files)
fi

FILES=$(echo "$FILES" | grep ^assets | awk '{print "put -z ./" $0 " ./" $0}')

ncftp <<EOF
open -u '$USER' -p '$PASS' '$HOST'
cd /www/pomidorko.$DOMAIN 
mkdir assets
mkdir assets/js
mkdir assets/css
mkdir assets/img
mkdir assets/sounds
put -zf ./build/$LANG.html index.php
$FILES
EOF
<?php echo code(ob_get_clean(), 'sh', 'big') ?>

Данный скрипт загружает разницу файлов между сейчашним и последним созданным 
коммитом на FTP сервер. Если этому скрипту дать третий аргумент который равен 
строке "true", то делается полный upload файлов на FTP сервер.

Информация подключения к FTP серверу находится в файле ftp.sh (который не 
находится в индексе git). Ну чтобы пароль и хост нечаянно не попал в git 
репозиторий.

А сам деплой выполняется одной командой в консоле:

```sh
# Частичный деплой
make deploy

# Полный деплой
make deploy FULL_DEPLOY=true
```

<?php

return [
    'title'     => 'Помидорковый таймер',
    // 'name'   => 'pomidorko',
    'view'      => 'templates/project.jade',
    'processor' => 'markdown'
];