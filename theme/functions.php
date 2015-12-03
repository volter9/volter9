<?php

/**
 * Text "slugification"
 * 
 * @param string $text
 * @return string
 */
function slugify ($text) {
    $slug = strtolower($text);
    $slug = preg_replace('/[^\w\d\_\-]/', '-', $slug);
    
    return trim($slug, '-');
}

/**
 * @param string $path
 * @return string
 */
function basepath ($path = '') {
    return BASEPATH . "/$path";
}

/**
 * @param string $content
 * @param string $classes
 * @return string
 */
function spoiler ($content, $classes = '') {
    $classes = $classes ? " $classes" : '';
    
    return sprintf('<div class="spoiler%s">%s</div>', $classes,  $content);
}

/**
 * Process code
 * 
 * @param string $content
 * @param string $lang
 */
function code ($content, $lang) {
    $content = htmlspecialchars($content, ENT_NOQUOTES, 'UTF-8');
    $content = trim($content);
    $content = strtr($content, [
        '[?' => '&lt;?php',
        '?]' => '?&gt;'
    ]);
    
    return sprintf('<pre class="language-%s"><code>%s</code></pre>', $lang, $content);
}

/**
 * @param string $content
 * @param string $lang
 * @param string $size
 * @param string $classes
 * @return string
 */
function spoiler_code ($content, $lang, $size = '', $classes = '') {
    $classes = $classes ? " $classes" : '';
    
    if ($size) {
        $classes = "spoiler-{$size}{$classes}";
    }
    
    return spoiler(code($content, $lang), $classes);
}

/**
 * Get all blog posts
 * 
 * @param int $limit
 * @return array
 */
function blog_posts (Bloge\Content\IContent $content, $limit = 0) {
    $posts = array_map(
        function ($file) use ($content) {
            try {
                return $content->fetch($file);
            }
            catch (Bloge\NotFoundException $e) {
                return false;
            }
        },
        $content->browse('blog')
    );
    
    usort($posts, function ($a, $b) {
        return strtotime($b['date']) 
             - strtotime($a['date']);
    });
    
    $posts = array_filter($posts);
    
    return $limit
        ? array_slice($posts, 0, $limit)
        : $posts;
}

/**
 * Format date
 * 
 * @param string $date
 * @return string
 */
function format_date ($date) {
    static $months = [
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь'
    ];
    
    $date = strtotime($date);

    return $months[date('m', $date) - 1] . date(' j, Y', $date);
}