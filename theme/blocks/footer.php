<footer class="footer">
    <div class="fluid">
        <ul class="footer-menu clearfix">
            <li>
                &copy; 2015
            </li>
            <li>
                <a href="http://twitter.com/volter_9"
                   target="_blank">Twitter</a>
            </li> 
            <li>
                <a href="http://github.com/volter9"
                   target="_blank">Github</a>
            </li>
            <li>
                <a href="#">Наверх</a>
            </li>
            <li>
                Powered by <a href="https://github.com/bloge/bloge">Bloge</a>
            </li>
        </ul>
    </div>
</footer>

<?php if (isset($js)): foreach ($js as $script): ?>
<script src="<?php echo $url->make($script) ?>" 
        type="text/javascript"></script>
<?php endforeach; endif; ?>

<script src="<?php echo $url->make('assets/uploads/likely/likely.js') ?>"
        type="text/javascript"></script>
<script src="<?php echo $url->make('assets/js/spoiler.js') ?>"
        type="text/javascript"></script>
<script src="<?php echo $url->make('assets/js/hljs.js') ?>"
        type="text/javascript"></script>
<script type="text/javascript">
    typeof hljs !== 'undefined' && hljs.initHighlightingOnLoad();
</script>