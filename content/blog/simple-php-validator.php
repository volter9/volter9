Однажды, один мой знакомый спросил меня, как 
<abbr title="Человек который пишет велосипеды">велосипедиста</abbr>, как 
бы я реализовал простую валидацию данных. 
Ну если там несколько полей, то можно делать проверку через `empty` или `isset`:

```php
if (empty($_POST['name'])) {
    die('Поле "имя" не введено');
}

if (
    empty($_POST['password']) || 
    empty($_POST['password_confirm'])
) {
    die('Поле "пароль" не введено');
}
```

А если нужна более сложная валидация данных то тут необойтись без написание 
простой маленькой библиотеки для валидации данных. Встречайте «Валидатор 2000»:

<?php ob_start() ?>
/**
 * Валидатор 2000
 * 
 * @author volter9
 */

/**
 * @param array $data
 * @param array $rules
 * @return array
 */
function validate (array $data, array $rules) {
    $errors = [];
    
    foreach ($rules as $key => $rule) {
        $error = validate_field($data[$key], parse_rule($rule), $data);
        
        if ($error) {
            $errors[$key] = $error;
        }
    }
    
    return $errors;
}

/**
 * @param mixed $value
 * @param array $rule
 * @param arary $data
 * @return array
 */
function validate_field ($value, array $rule, array $data = []) {
    $errors = [];
    
    foreach ($rule as $validator => $args) {
        $vargs = array_merge([$value, $data], $args);
        
        if (!call_user_func_array($validator, $vargs)) {
            $errors[$validator] = $args;
        }
    }
    
    return $errors;
}

/**
 * @param string $rule
 * @return array
 */
function parse_rule ($rule) {
    $rule = !$rule ? [] : $rule;
    
    if (is_array($rule)) {
        return $rule;
    }
    
    $result = [];
    $rules  = explode('|', $rule);
    
    foreach ($rules as $rule) {
        $frags = explode(':', $rule);
        
        $name = $frags[0];
        $args = isset($frags[1]) ? explode(',', $frags[1]) : [];
        
        $result[$name] = $args;
    }
    
    return $result;
}
<?php echo spoiler_code(ob_get_clean(), 'php', 'big') ?>

## Как все это работает

Чтобы провести валидацию данных нужно воспользоваться функцией `validate`.

Функция `validate` берет два аргумента: ассоциативный массив с данными и 
ассоциативный массив с правилами для этих данных.

Массив данных может содержать в себе все что угодно. Числа, строки, подмассивы, и т.д.

Массив с правилами должен содержать в себе пару ключ-значение, где ключ это 
название поля в массиве данных, а значение может быть либо форматированной 
строкой (упрощенную запись) в виде:

```
имя_валидатора|второй_валидатор:с одним аргументом|третий_валидатор:с двумя аргументами,2
```

Или же значение может быть массивом из ключей-значений где ключ это название валидатора,
а значение это массив с аргументами которые нужно передать в валидатор 
(эти значения могут быть чем угодно). Это обычная запись правил для валидации.

Пример упрощенной и обычной записи правил.

```php
$rules = [
    /* Упрощенная запись */
    'name' => 'required',
    
    /* Обычная запись */
    'password' => [
        'required' => [],
        'confirm' => ['password_confirm']
    ]
];
```

Можно использовать оба формата в функции `validate`.

Когда функция `validate` получает массив правил, она сначала приводит правила
в обычную запись с помощью функции `parse_rule` (массив с аргументами).
После обработки правила во время каждой итерации данных, функция `validate` проводит 
валидацию каждого поля с помощью функции `validate_field` передавая внутрь значение, 
обработанные правила и массив с данными.

Алгоритм функции `validate_field` очень прост. Эта функция получает три аргумента: 
значение из массива с данных, правила в обычной форме и входной массив данных 
(необязательный аргумент).
Эта функция проходится по всем правилам и вызывает валидаторы на переданном значение, 
если значение не проходит валидатор то функция собирает аргументы от валидатора 
в массив с ошибками, и возвращает массив с ошибками после окончания итерации.

На этом все об алгоритме, теперь немного о валидаторах.

## Валидаторы

Для массива правил нужно обозначить валидатор для каждой поля (в виде ключа). 
Валидатор это простая пользовательская функция которая должна возвращать булевое значение. 
По умолчанию, в эту функцию поступает два параметра: значение поля и массив данных.
Все аргументы которые были переданны в правила идут после этих два аргументов.

Пример валидатора:

```php
function required ($value) {
    return !empty($value);
}
```

И пример валидатора с дополнительными аргументами:

```php
function confirm ($value, $array, $field) {
    return isset($array[$field])
        && (string)$value === (string)$array[$field];
}
```

Для валидатора выше, нужно передать один аргумент в списке правил для поля:

```php
// Упрощенная запись
'confirm:password_confirm'

// Обычная запись
[
    'confirm' => ['password_confirm']
]
```

## Пример использование библиотеки

Пример использования библиотеки:

<?php ob_start() ?>
/** Подключаем валидатор 2000 */
require 'validator.php';

/** Валидаторы */
function required ($value) {
    return !!$value;
}

function confirm ($value, $array, $field) {
    return isset($array[$field])
        && (string)$value === (string)$array[$field];
}

/**
 * $rules - правила для валидации
 * $pass_data - данные которые пройдут валидацию
 * $fail_data - данные которые не пройдут валидацию
 */

$rules = [
    'name' => 'required',
    'password' => 'required|confirm:password_confirm'
];

$pass_data = [
    'name' => 'Вася Пупкин',
    'password' => '123456',
    'password_confirm' => '123456'
];

$fail_data = [
    'name' => '',
    'password' => '123456',
    'password_confirm' => '123'
];

if (!validate($pass_data, $rules)) {
    echo 'Валидация прошла';
}

$errors = validate($fail_data, $rules);

if ($errors) {
    echo 'Произошла ошибка:';
    
    var_dump($errors);
}
<?php echo spoiler_code(ob_get_clean(), 'php', 'big') ?>

Также данная библиотека доступна на 
[GitHub Gist](http://gist.github.com/volter9/2d0bf88fceb8bdbfd201). Лицензия MIT.

<?php return [
    'title'     => 'Простой PHP валидатор',
    'date'      => '06-10-2015 14:02:37',
    'category'  => 'PHP',
    'tags'      => ['валидация', 'KISS', 'YAGNI', 'минимализм', 'велосипед'],
    'processor' => 'markdown'
];