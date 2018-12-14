@if (setting('social.facebook') || setting('social.twitter') || setting('social.google'))
    <div class="social-media">
        <ul class="social-tabs">
            @if (setting('social.facebook'))
                <li class="tab1 active">
                    <span class="fb-icon"></span>
                    <a href="#">Facebook</a>
                </li>
            @endif
            @if (setting('social.twitter.name'))
                <li class="tab2">
                    <span class="twitter-icon"></span>
                    <a href="#">Twitter</a>
                </li>
            @endif
            @if (setting('social.google'))
                <li class="tab3">
                    <span class="gplus-icon"></span>
                    <a href="#">Google+</a>
                </li>
            @endif
        </ul>
        <div class="social-tab-content">
            @if (setting('social.facebook'))
                <div class="tab1 active">
                    <div class="fb-container">
                        <div class="fb-page"
                             data-href="{{ stripos(setting('social.facebook'), 'http') !== false ? setting('social.facebook') : 'https://www.facebook.com/'.setting('social.facebook') }}"
                             data-small-header="false" data-adapt-container-width="true" data-hide-cover="true"
                             data-show-facepile="true" data-show-posts="false">
                            <div class="fb-xfbml-parse-ignore">
                                <blockquote cite="https://www.facebook.com/facebook">
                                    <a href="https://www.facebook.com/facebook">Facebook</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div> <!-- tab1 -->
            @endif
            @if (setting('social.twitter.name'))
                <div class="tab2">
                    <div class="twitter-container">
                        <a class="twitter-timeline" href="https://twitter.com/{{ setting('social.twitter.name') }}">Tweets
                            by {{ setting('social.twitter.name') }}</a>
                    </div>
                </div> <!-- tab2 -->
            @endif
            @if (setting('social.google'))
                <div class="tab3">
                    <div class="gplus-container">
                        <g:page href="https://plus.google.com/{{ setting('social.google') }}"></g:page>
                    </div>
                </div> <!-- tab 3 -->
            @endif
        </div> <!-- end of tab content -->
    </div> <!-- end of social media -->
@endif