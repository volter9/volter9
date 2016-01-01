Привет! Давно я не писал в свой бложик. Пора исправить эту ситуацию. В данном 
посте я опишу достойнства юнит тестирования и TDD.

## Юнит тестирование

<a href="https://ru.wikipedia.org/wiki/Модульное_тестирование" target="_blank">Википедия</a> 
определяет юнит тестирование следующим образом:

> ... юнит-тестирование — процесс в программировании, позволяющий проверить на 
> корректность отдельные модули исходного кода программы.

Т.е. этот процесс позволяет тестировать отдельные классы и функции в "вакуме" 
(как они есть по себе без всяких зависимостей и вне контекста программы).

В первую очередь чтобы убедить тебя в чем преймущество юнит тестирование, мне 
нужно задать простой риторический вопрос: "какую выгоду даст мне юнит 
тестирование?".

Ответ очень прост. Юнит тестирование даст тебе способ проверить отдельные 
фукнции (методы) на соответсвия твоим ожиданиям. Проще говоря в юнит тесте ты 
описываешь функционал и что должен этот функционал делать (какие значения 
функции должны возвращать) при определенной обстоятельствах. Это дает тебе 
следующии преймущества:

* Твой код будет соответствовать твоим ожиданиям (меньше вероятность получить 
  сюрприз в виде бага)
* При рефакторе, если ты сломал какой то функционал (нечайно), ты сможешь 
  узнать это намного быстрее. Все что нужно сделать это запустить юнит тесты еще 
  раз 
* Если правильно писать юнит тесты, твой код будет намного лучше по качеству из-за 
  того что юнит тестирование заставляет тебя думать в конкретном контексте 
  (концентрирует твое внимание только на одном аспекте)

Пример простого юнит теста на PHP и 
<a href="https://phpunit.de" target="_blank" title="PHP фреймоворк для юнит тестирование">PHPUnit</a>:

```php
class Addition 
{
    /**
     * Сложит два числа
     * 
     * @param int $a
     * @param int $b
     * @return int
     */
    public function add($a, $b)
    {
        return $a + $b;
    }
}

class AdditionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Тестирование единственного метода `add` на правильную работу
     * вычислений
     */
    public function testAddition()
    {
        $addition = new Addition;
        
        $this->assertEquals(10, $addition->add(4, 6));
    }
}
```

В данном упрощенном примере, я проверяю класс `Addition` на соотвествие моим
ожиданиям: `4 + 6` должно всегда возвращать `10`.

## TDD

TDD (Test Driven Development – Разработка через тестирование) 
это дисциплина (как ООП) связанная с юнит тестированием. Смысл 
TDD это сначала написать тесты а после этого уже рабочий код. Процесс написания 
кода через TDD обычно проходит через следующии этапы:

1. Пишем сначала голый тест и запускаем его. Мы должны получить 
   ошибку от компилятора/интерпретатора что такого класса/функции не существует.
2. Мы создаем класс и пустой метод (или функцию) который мы тестируем в данный 
   момент. Теперь после запуска тестов мы должны получить ошибку уже от самого 
   фреймворка, что метод/функцию который мы тестируем не возвращает правильное 
   значение.
3. Теперь мы можем уже написать минимальную реализацию метода чтобы пройти выше 
   описанный тест. Запускаем тест и мы должны получить сообщение что наш тест 
   был пройден.
4. Добавляем еще пару тестов с разными входными значениями и ожиданием.
   Мы снова должны получить ошибку из-за того что результат метода/функции 
   не совпадает с новыми значениями.
5. И наконец-таки мы можем полностью переписать метод/функцию чтобы он проходил все 
   тесты. В итоге мы получим полностью работающий код как задумывалось и 
   пройденные тесты.

А теперь я покажу это на примере класса `Addition`.

### TDD на примере класса Addition

В данной секции я покажу наглядно простой пример TDD на примере класса `Addition` и 
фреймворка для юнит тестирования PHPUnit. Для начала создаем только тест:

```php
class AdditionTest extends PHPUnit_Framework_TestCase
{
    public function testAddition()
    {
        $addition = new Addition;
        
        $this->assertEquals(10, $addition->add(4, 6));
    }
}
```

Сохраним этот класс в файл `AdditionTest.php`. Теперь давайте запустим этот 
тест в косноли с помощью PHPUnit:

```sh
phpunit AdditionTest.php
```

В итоге мы должны получить PHP ошибку что некий класс `Addition` не был найден. 
Первая фаза выполнена. Теперь наша задача это создать класс `Addition` и пустой 
метод `add`:

```php
class Addition
{
    public function add($a, $b)
    {
        // Тут будет реализация позже
    }
}
```

Сохраняем этот класс как `Addition.php`, подключаем класс через `require` в 
`AdditionTest.php` и запускаем тест еще раз. В итоге мы получим похожий вывод:

```
PHPUnit 4.8.10 by Sebastian Bergmann and contributors.

F

Time: 183 ms, Memory: 5.25Mb

There was 1 failure:

1) AdditionTest::testAddition
Failed asserting that null matches expected 10.

/Users/Volter/.../AdditionTest.php:11

FAILURES!
Tests: 1, Assertions: 1, Failures: 1.
```

Фаза №2 была выполнена, приступаем к следующей. Теперь нам надо чтобы класс 
`Addition` проходил с минимальными усилиями. В данной ситуации все что нам 
нужно сделать это добавить `return 10` в `Addition.php`:

```php
class Addition
{
    public function add($a, $b)
    {
        return 10;
    }
}
```

Запускаем тест, и узнаем что наш тест прошел успешно:

```
PHPUnit 4.8.10 by Sebastian Bergmann and contributors.

.

Time: 176 ms, Memory: 5.00Mb

OK (1 test, 1 assertion)
```

Третья фаза была выполнена успешно. Наш класс проходит тест, теперь нужно 
добавить еще пару утверждений (assert) в код чтобы наш класс функционировал:

```php
class AdditionTest extends PHPUnit_Framework_TestCase
{
    public function testAddition()
    {
        $addition = new Addition;
        
        $this->assertEquals(10, $addition->add(4, 6));
        $this->assertEquals(15, $addition->add(10, 5));
        $this->assertEquals(20, $addition->add(8, 12));
    }
}
```

Запускаем тест еще раз и... мы видим ошибку, наш тест не был пройден т.к. 
возвращаемое значение не соответствовало ожиданием: 

```
PHPUnit 4.8.10 by Sebastian Bergmann and contributors.

F

Time: 181 ms, Memory: 5.25Mb

There was 1 failure:

1) AdditionTest::testAddition
Failed asserting that 10 matches expected 15.

/Users/Volter/.../AdditionTest.php:12

FAILURES!
Tests: 1, Assertions: 2, Failures: 1.
```

В итоге мы прошли еще одну фазу, четвертую фазу <!-- луны -->. Теперь настал час 
для последней фазы. Нужно переписать метод `Addition::add` так чтобы он проходил 
тесты и функционировал. Для этого нам нужно поменять всего лишь одну строчку в 
`Addition.php`:

```php
class Addition
{
    public function add($a, $b)
    {
        return $a + $b;
    }
}
```

Запускаем тест, и profit:

```
PHPUnit 4.8.10 by Sebastian Bergmann and contributors.

.

Time: 178 ms, Memory: 5.00Mb

OK (1 test, 3 assertions)
```

## Заключение

Хоть юнит тестирование и TDD требует больше времени и усилий, но оно 
повышает качество и модульность кода и понижает вероятность возникновения 
логических ошибок в отдельных модулях, если, конечно же, все сделано правильно.

Если есть какие нибудь вопросы или поправки (что я в чем то не прав), жду ваших 
комментариев. 

<?php

return [
    'title'     => 'Юнит тестирование и TDD',
    'date'      => '01-01-2016 10:00:00',
    'category'  => 'PHP',
    'tags'      => ['юнит тестирование', 'PHPUnit', 'TDD'],
    'processor' => 'markdown',
    'draft'     => true
];