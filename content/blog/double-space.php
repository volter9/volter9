Почему многие JS разработчики используют два пробела для отступа вместо табов или 
4-ех пробелов? Это типа модно?

С двумя пробелами получается каша а не код. Как бы хорошо он не был бы написан, 
он все равно нечитабелен. Из-за маленького отступа между строчками плохо виден отступ. 
Также, многие JS разработчики не разделяют блоки кода друг от друга логически, 
в итоге получается вот такая нечитабельная каша:

<?php ob_start() ?>
'use strict'
var validate = require('aproba')

module.exports = function (tree) {
  validate('O', arguments)
  var seen = {}
  var flat = {}
  var todo = [[tree, '/']]
  while (todo.length) {
    var next = todo.shift()
    var pkg = next[0]
    seen[pkg.path] = true
    var path = next[1]
    flat[path] = pkg
    if (path !== '/') path += '/'
    for (var ii = 0; ii < pkg.children.length; ++ii) {
      var child = pkg.children[ii]
      if (!seen[child.path]) {
        todo.push([child, flatName(path, child)])
      }
    }
  }
  return flat
}

var flatName = module.exports.flatName = function (path, child) {
  validate('SO', arguments)
  return path + (child.package.name || 'TOP')
}
<?php echo spoiler_code(ob_get_clean(), 'code', 'js') ?>

<p class="notice">
    Один из исходников 
    <a href="https://github.com/npm/npm/blob/d2178a9ea034ede58f02919f259ee072a6554c59/lib/install/flatten-tree.js" 
       title="Node Package Manager" 
       target="blank">NPM</a>
</p>

Мне не удалось с первого раза прочитать этот код и понять что он делать. 
Этот код не читабелен.
Вся его проблема читабельности этого кода в том что он слишком сжат. 
У нету разделения между блоками и имеется отступ в два пробела.

После форматирование, код становится более читабельным:

<?php ob_start() ?>
'use strict'

var validate = require('aproba')

module.exports = function (tree) {
    validate('O', arguments)

    var seen = {},
        flat = {},
        todo = [[tree, '/']]
    
    while (todo.length) {
        var next = todo.shift(),
            pkg  = next[0],
            path = next[1]
        
        seen[pkg.path] = true
        flat[path] = pkg
        
        if (path !== '/') path += '/'
        
        for (var ii = 0; ii < pkg.children.length; ++ii) {
            var child = pkg.children[ii]
            
            if (!seen[child.path]) {
                todo.push([child, flatName(path, child)])
            }
        }
    }
    
    return flat
}

var flatName = module.exports.flatName = function (path, child) {
    validate('SO', arguments)
    
    return path + (child.package.name || 'TOP')
}
<?php echo spoiler_code(ob_get_clean(), 'code', 'js') ?>

Все что я сделал это разделил код на логические блоки и заменил отступ в два 
пробела на четыре пробела. 
Разве код стал более читабельным? По моему, да.

<?php return [
    'title'     => 'Два пробела',
    'date'      => '05-10-2015 09:36:44',
    'category'  => 'JavaScript',
    'tags'      => ['npm', 'ИМХО', 'форматирование'],
    'processor' => 'markdown'
];
