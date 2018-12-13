@extends('site::app')

@section('title')
    {{ isset($category) ? $category->title.' - ' : '' }} @parent
@stop

@section('content')
    <div class="posts" data-url="{{ URL::current() }}">
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