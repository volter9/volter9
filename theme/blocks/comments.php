<?php if (!isset($no_comments) && !DYNAMIC): ?>
<div class="post-comments">
    <h2>Комментарии</h2>

    <div id="disqus_thread"></div>
    <script>
        var disqus_config = function () {
            this.page.url = '<?php echo "http://volter9.github.io/blog/$route" ?>';
            this.page.identifier = '<?php echo $route ?>';
        };
    
        (function() {
            // Stylish...
            var d = document, 
                s = d.createElement('script');
    
            s.src = '//volter9-github-io.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
        
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>
        Please enable JavaScript to view the 
        <a href="https://disqus.com/?ref_noscript" rel="nofollow">
            comments powered by Disqus.
        </a>
    </noscript>
</div>
<?php endif ?>