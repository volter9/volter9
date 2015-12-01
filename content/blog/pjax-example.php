<abbr title="Too Long; Don't Read">TL;DR</abbr> – пример внизу.

Вчера, я наткнулся на плагин [PJAX](https://github.com/defunkt/jquery-pjax) для 
jQuery. Решил я потестировать этот плагин. 
К моему сожалению, код из примера не хотел работать с полноценными HTML 
документами (без конфигурации приложения, это относится для статических сайтов
вроде моего).

По этой причине, мне пришлость лезть в исходный код плагина и смотреть в чем проблема.
Изначально я думал что проблема была в том что веб-сервер неправильно обрабатывает 
AJAX запросы т.к. Safari консоль не показывала AJAX запрос.

В итоге вычислилось что все работает, но в исходном код содержимое AJAX запроса 
не доходит до точки вывода содержимого в основной контейнер.

<?php ob_start() ?>
function extractContainer() {
  /* ... */
  
  /**
   * Если не указать в options ключ fragment то содержимое AJAX запроса 
   * не дойдет до места вывода, но это при условие что содержимое AJAX 
   * запроса это полноценный HTML документа с DOCTYPE, html, head и body
   */
  if (options.fragment) {
    // If they specified a fragment, look for it in the response
    // and pull it out.
    if (options.fragment === 'body') {
      var $fragment = $body
    } else {
      var $fragment = findAll($body, options.fragment).first()
    }

    if ($fragment.length) {
      obj.contents = options.fragment === 'body' ? $fragment : $fragment.contents()

      // If there's no title, look for data-title and title attributes
      // on the fragment
      if (!obj.title)
        obj.title = $fragment.attr('title') || $fragment.data('title')
    }

  } else if (!fullDocument) {
    obj.contents = $body
  }
  
  /* ... */
}
<?php echo spoiler_code(ob_get_clean(), 'js', 'big') ?> 

Таким образом я потратил впустую пол часа на разгадку "почему же PJAX не работает?"
Было бы намного легче если бы данный плагин кинул исключение с сообщением вроде:

> ## Ахтунг!
> 
> Я получил ответ с сервера и это оказался полноценный HTML документ, омг  
> Тебе нужно установить fragment свойство в параметрах чтобы я смог нормально
> обработать HTML ответ с сервера

А теперь сам пример:

<div class="tabs-container full">
    <!-- script.js -->
    <div class="tab">script.js</div>
    <div data-tab="script.js">
<?php ob_start() ?>
$(function () {
    /**
     * PJAX будет срабатывать после нажатие на любую ссылку на странице
     * и загружать фрагмент (контейнер #pjax-container внутри фрагмента) 
     * AJAX запроса в #pjax-container
     */
    $(document).pjax('a', '#pjax-container', {
        fragment: '#pjax-container'
    });
});
<?php echo code(ob_get_clean(), 'js') ?> 
    </div>
    <!-- index.html -->
    <div class="tab">index.html</div>
    <div data-tab="index.html">
<?php ob_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="jquery.pjax.js"></script>
        <script src="script.js"></script>
    </head>
    
    <body>
        <h1>Заголовок сайта</h1>
        
        <div id="pjax-container">
            <p>
                Привет мир! Чтобы увидеть PJAX в действие, 
                <a href="page.html">перейдите по этой ссылке</a>.
            </p>
        </div>
        
        <footer>2015+</footer>
    </body>
</html>
<?php echo code(ob_get_clean(), 'html') ?> 
    </div>
    
    <!-- page.html -->
    <div class="tab">page.html</div>
    <div data-tab="page.html">
<?php ob_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page</title>
        
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="jquery.pjax.js"></script>
        <script src="script.js"></script>
    </head>

    <body>
        <h1>Заголовок сайта</h1>
    
        <div id="pjax-container">
            <p>
                Эта страница должна была загрузится с помощью PJAX.
                Теперь вы увидели PJAX в действие, <a href="index.html">обратно</a>?
            </p>
        </div>
    
        <footer>2015+</footer>
    </body>
</html>
<?php echo code(ob_get_clean(), 'html') ?> 
    </div>
</div>
<p class="notice">
    Файл jquery.pjax.js нужно скачать с оффициального GitHub репозитория плагина
</p>

Я думаю что этот пример нужно обязательно добавить в README.md PJAX плагина для
jQuery. Хотя ниже в README, в секции "Response types that force a reload", 
данная проблема описана, жалко что оно там оче.

<?php return [
    'title'     => 'Как использовать PJAX',
    'date'      => '07-10-2015 17:23:12',
    'category'  => 'JavaScript',
    'tags'      => ['PJAX', 'jQuery', 'свисто-перделки'],
    'processor' => 'markdown'
];