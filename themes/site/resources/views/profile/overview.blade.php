@extends('site::app')

@section('title')
    {{ $user->name }} - @parent
@endsection

@section('content')
    @include('site::partials.profile-header', compact('user'))
    <div class="posts" data-url="{{ URL::current() }}">
        @if (count($activities) > 0)
            @foreach ($activities as $activity)
                <article>
                    <div class="activity">
                        <span class="username">{{ $activity->user->name }}</span>
                        @if ($activity->eventName == 'post.create')
                            {{ __('posted') }}
                        @endif
                        @if ($activity->eventName == 'post.comment')
                            {{ __('commented') }}
                        @endif
                        @if ($activity->eventName == 'post.vote.like')
                            {{ __('liked') }}
                        @endif
                        @if ($activity->eventName == 'post.vote.dislike')
                            {{ __('didn\'t like') }}

                        @endif
                    </div>
                    @include('site::partials.post', ['post' => $activity->post])
                </article>
                <div class="divider"></div>
            @endforeach
        @else
            <article class="db-message">
                <p>{{ __('There are no activities made yet by :name!', ['name' => $user->name]) }}</p>
            </article>
        @endif
    </div> <!-- end of posts -->
@stop