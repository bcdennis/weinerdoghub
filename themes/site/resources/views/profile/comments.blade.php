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
                    @include('site::partials.post', ['post' => $activity->post])
                </article>
                <div class="divider"></div>
            @endforeach
        @else
            <article class="db-message">
                <p>{{ __('Sorry, but :name is quite shy!', ['name' => $user->name]) }}</p>
            </article>
        @endif
    </div>
@stop