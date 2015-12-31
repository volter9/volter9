<?php

/**
 * @const string BASEPATH
 * @const string FULL_URL
 * @const bool DYNAMIC
 */
define('BASEPATH', __DIR__);
define('FULL_URL', 'http://volter9.github.io');
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

$renderer = new Renderer(basepath('theme'));
$content  = new Advanced(new Content(basepath('content')));

/** 
 * Dispatcher: ignore private folders and map 404 and feed to files 
 */
$content
    ->dispatcher()
    ->map(require 'content/_data/mappings.php')
    ->ignore(Bloge\rFilter('/^_|\/_/'));

/** 
 * Processor: process markdown inside of the articles 
 */
$content
    ->processor()
    ->add(function ($route, array $data) use ($parsedown) {
        return @$data['processor'] === 'markdown' 
            ? $parsedown($route, $data)
            : $data;
    });

/** 
 * DataMapper: map default variables, route and content map 
 */
$content
    ->dataMapper()
    ->mapAll([
        'container' => $content,
        'theme'     => $renderer,
        'view'      => 'templates/post.jade',
        'data'      => new Data(basepath('content/_data')),
        'url'       => new URL(FULL_URL, URL::baseUrl(__DIR__))
    ])
    ->mapAll(function ($route) {
        return compact('route');
    })
    ->map(require 'content/_data/data.php');

return new AdvancedApp($content, $renderer);