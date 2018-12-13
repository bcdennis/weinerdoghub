<div class="ibox-title settings-nav">
    <div class="row secondary-navigation">
        <nav class="navbar" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar-settings" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-cog"></i>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-settings">
                <ul class="nav navbar-nav">
                    <li {!! adminSetActive('settings.appearance') !!}>
                        <a href="{{ route('admin.settings.appearance') }}">
                            Branding &amp; Appearance
                        </a>
                    </li>
                    <li {!! adminSetActive('settings.conversion') !!}>
                        <a href="{{ route('admin.settings.conversion') }}">
                            Conversions
                        </a>
                    </li>
                    <li {!! adminSetActive('settings.restrictions') !!}>
                        <a href="{{ route('admin.settings.restrictions') }}">
                            Restrictions
                        </a>
                    </li>

                    <li {!! adminSetActive('settings.social') !!}>
                        <a href="{{ route('admin.settings.social') }}">
                            Social Media
                        </a>
                    </li>
                    <li {!! adminSetActive('settings.analytics') !!}>
                        <a href="{{ route('admin.settings.analytics') }}">
                            Analytics
                        </a>
                    </li>
                    <li {!! adminSetActive('settings.captcha') !!}>
                        <a href="{{ route('admin.settings.captcha') }}">
                            Recapthca
                        </a>
                    </li>
                    <li {!! adminSetActive('settings.email') !!}>
                        <a href="{{ route('admin.settings.email') }}">Email</a>
                    </li>
                    <li {!! adminSetActive('settings.comments') !!}>
                        <a href="{{ route('admin.settings.comments') }}">Comments</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div> <!-- end of secondary-navigation -->
</div> <!-- end of ibox-title -->