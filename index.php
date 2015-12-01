<?php

require 'vendor/autoload.php';

$app = require 'app.php';

try {
    echo $app->render(Volter\URL::url(__DIR__) ?: 'index');
} catch (Bloge\NotFoundException $e) {
    header('HTTP/1.1 404 Not Found');
    
    echo $app->render('404.html');
}