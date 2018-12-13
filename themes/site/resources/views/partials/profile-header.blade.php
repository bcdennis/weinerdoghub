<div class="profile-header">
    <div class="user-info">
        <div class="user-wrapper">
            <div class="useravatar {{ computeRank($user->points) }}">
                <img src="{{ avatar($user->avatar) }}" alt="User Avatar">
            </div>
            <span class="username">{{ $user->name }}</span>
        </div>

        <div class="meta">
            <span>{{ formatNumber($user->points) }} <span class="accent">{{ __choice('smiles', $user->points) }}</span> {{ __choice('generated', $user->points) }}</span>
            <span>{{ __('member since') }}: {{ $user->created_at->format('M Y') }}</span>
        </div>
    </div> <!-- end of user-info -->
    <nav class="profile-nav">
        <ul>
            <li {!! setProfileActive($user, 'profile.overview') !!}>
                <a href="{{ route('profile.overview', $user->name) }}">{{ __('overview') }}</a>
            </li>
            <li {!! setProfileActive($user, 'profile.posts') !!}>
                <a href="{{ route('profile.posts', $user->name) }}">{{ __('own posts') }} ({{ formatNumber($user->posts) }})</a>
            </li>
            <li {!! setProfileActive($user, 'profile.smiles') !!}>
                <a href="{{ route('profile.smiles', $user->name) }}">{{ __('smiles at') }} ({{ formatNumber($user->likes) }})</a>
            </li>
            <li {!! setProfileActive($user, 'profile.comments') !!}>
                <a href="{{ route('profile.comments', $user->name) }}">{{ __('commented on') }} ({{ formatNumber($user->comments) }})</a>
            </li>
        </ul>
    </nav>
</div> <!-- end of profile-header -->
