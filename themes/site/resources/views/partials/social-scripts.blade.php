<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '{{ setting('comments.fb.id') }}',
            xfbml      : true,
            version    : 'v2.6'
        });
        @if ( !setting('comments.local.on') && setting('comments.facebook.on'))
            document.getElementById("fbBtn").click();
        @endif
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

@if (setting('comments.disqus.on'))
<script type="text/javascript">
    var disqus_shortname = '{{ setting('comments.disqus.id') }}';
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        @if ( ! (setting('comments.local.on') || setting('comments.facebook.on')) && setting('comments.disqus.on'))
        document.getElementById("disBtn").click();
        @endif
    })();
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>
@endif

@if (setting('social.on'))
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script type="text/javascript" async defer
            src="https://apis.google.com/js/platform.js?publisherid=113150176157103865974">
    </script>
@endif
