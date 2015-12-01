<?php 
    $classes = isset($classes) && is_string($classes) ? " $classes"              : '';
    $title   = isset($title) && is_string($title)     ? " data-title=\"$title\"" : '';
    $url     = isset($url) && is_string($url)         ? " data-url=\"$url\""     : '';
?>

<div class="likely<?php echo $classes ?>"<?php echo $url . $title ?>>
    <div class="twitter" data-via="volter_9">Твитнуть</div>
    <div class="vkontakte">Поделиться</div>
    <div class="facebook">Поделиться</div>
</div>