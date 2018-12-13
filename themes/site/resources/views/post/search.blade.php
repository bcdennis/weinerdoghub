@extends('site::app')

@section('title')
    {{ __('Search') }} - @parent
@stop

@section('content')
    <div class="posts search" data-url="{{ URL::current() }}" data-q="{{ $searchStr }}">
        <div class="searched-for">
            <p>{{ __('You searched for') }}: '<em>{{ $searchStr }}</em> '</p>
        </div>
    @if (count($posts) > 0)
            @foreach ($posts as $post)
                <article>
                    @include('site::partials.post', ['post' => $post])
                </article>
                <div class="divider"></div>
            @endforeach
        @else
            <article class="db-message">
                <p>{{ __('Sorry, no content is available for the moment, please smile later!') }}</p>
            </article>
        @endif
    </div>
@stop