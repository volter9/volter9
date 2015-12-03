<?php

/**
 * @const string BASEPATH
 */
define('BASEPATH', __DIR__);

/**
 * @const bool DYNAMIC
 */
define('DYNAMIC', PHP_SAPI !== 'cli');

require 'theme/functions.php';

use Bloge\Apps\AdvancedApp;
use Bloge\Content\Advanced;
use Bloge\Content\PHP as Content;
use Bloge\Renderers\Jade as Renderer;
use Volter\Data;
use Volter\URL;

/**
 * Bloge app
 * 
 * @package volter9.github.io
 */

$parsedown = Bloge\process('content', [new Parsedown, 'text']);

$renderer = new Renderer(__DIR__ . '/theme', __DIR__ . '/cache');
$content  = new Advanced(new Content(__DIR__ . '/content'));

/** Dispatcher: ignore private folders and map 404 and feed to files */
$content
    ->dispatcher()
    ->map(require 'content/_data/mappings.php')
    ->ignore(Bloge\rFilter('/^_|\/_/'));

/** Processor: process markdown inside of the articles */
$content
    ->processor()
    ->add(function ($route, array $data) use ($parsedown) {
        return @$data['processor'] === 'markdown' 
            ? $parsedown($route, $data)
            : $data;
    })
    ->add(function ($route, array $data) {
        return isset($data['draft']) ? [] : $data;
    });

/** DataMapper: map default variables, route and content map */
$content
    ->dataMapper()
    ->mapAll([
        'content' => $content,
        'theme'   => $renderer,
        'view'    => 'templates/post.jade',
        'data'    => new Data(__DIR__ . '/content/_data'),
        'url'     => new URL('http://volter9.github.io', URL::baseUrl(__DIR__))
    ])
    ->mapAll(function ($route) {
        return compact('route');
    })
    ->map(require 'content/_data/data.php');

return new AdvancedApp($content, $renderer);