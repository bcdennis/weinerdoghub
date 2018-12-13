@extends('site::app')

@section('title')
    {{ $user->name }} - @parent
@endsection

@section('content')
    @include('site::partials.profile-header', compact('user'))
    <div class="posts profile own-posts" data-url="{{ URL::current() }}">
        @if (count($activities) > 0)
            @foreach ($activities as $activity)
                <article>
                    @include('site::partials.post', ['post' => $activity->post])
                </article>
                <div class="divider"></div>
            @endforeach
        @else
            <article class="db-message">
                <p>{{ __(':name has nothing to share with us for the moment!', ['name' => $user->name]) }}</p>
            </article>
        @endif
    </div>

    <div class="modal modal-upload modal-edit-post">
        <button class="modal-close"><span>x</span></button>
        <h2 class="modal-heading">{{ __('Edit Post') }}</h2>
        <p class="modal-subheading"></p>

        <form action="#" id="edit-post-form">
            <div class="form-group title">
                <label for="edit-title" class="sr-only">{{ __('Title') }}</label>
                <textarea name="title" class="post-title" id="edit-title" placeholder="{{ __('Title') }}"></textarea>
            </div>
            <div class="form-group dropdown-checkboxes-wrapper categories">
                <div class="dropdown-checkboxes">
                    <span class="cts categories-selected">{{ __('Select a category') }} ({{ __('max') }} {{ setting('maximum-categories', 2) }})</span>
                    <span class="categories-selected-text hide">{{ __('Select a category') }} ({{ __('max') }} {{ setting('maximum-categories', 2) }})</span>
                    <span class="caret"></span>
                </div>
                <ul class="checkboxes-list" data-max-cat="{{ setting('maximum-categories', 2) }}">
                    @foreach ($categories as $category)
                        @if ( ! $category->template || $category->template == 'nsfw')
                            <li>
                                <label>{{ $category->title }}
                                    <input type="checkbox" class="c-{{ $category->id }}" name="categories[{{ $category->slug }}]" value="{{ $category->slug }}">
                                </label>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="form-group post-description description">
                <label for="edit-description" class="sr-only">{{ __('Description') }}</label>
                <textarea name="description" id="edit-description" placeholder="{{ __('Description') }}"></textarea>
            </div>
            <div class="upload-footer">
                <button type="button" class="btn btn-upload"><span>{{ __('Save') }}</span></button>
            </div>
        </form>
    </div> <!-- end of modal-edit-post -->
@stop