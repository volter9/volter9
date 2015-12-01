<?php $title = !empty($title) ? "$title &ndash; " : '' ?>
<meta charset="utf-8">
<meta name="viewport" 
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<title><?php echo $title ?>volter9.github.io</title>

<link href="<?php echo $url->make('assets/uploads/likely/likely.css') ?>"
      rel="stylesheet"
      type="text/css">
<link href="<?php echo $url->make('assets/css/main.css') ?>"
      rel="stylesheet"
      type="text/css">
<link href="<?php echo $url->make('assets/css/theme.css') ?>"
      rel="stylesheet"
      type="text/css">

<?php if (isset($css)): foreach ($css as $styles): ?>
<link href="<?php echo $url->make($styles) ?>"
      rel="stylesheet"
      type="text/css">
<?php endforeach; endif; ?>

<link rel="alternate" type="application/rss+xml"
      href="<?php echo $url->make('feed.xml') ?>" 
      title="RSS Feed">