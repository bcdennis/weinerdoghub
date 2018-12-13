@extends('site::app')

@section('title')
    {{ __('Make a list') }} - @parent
@stop

@section('content')
    <div class="make-list form-wrapper">
        <h2>{{ __('Make a list') }}</h2>

        <form action="{{ route('posts.list') }}" method="post" enctype="multipart/form-data" id="list-upload-form">
            <div class="list-form">
                <div class="form-group general">
                </div>
                <div class="form-group media">
                    <label for="list-media">{{ __('List Image Preview') }}</label>
                    <input type="file" name="media" id="list-media">
                </div>

                <div class="form-group title">
                    <label for="list-tile" class="sr-only">{{ __('List Title') }}</label>
                    <input type="text" name="title" id="list-title" placeholder="{{ __('List Title') }}">
                </div>

                <div class="form-group description">
                    <label for="list-description" class="sr-only">{{ __('List Description') }} ({{ __('optional') }})</label>
                    <textarea name="description" id="list-description" placeholder="{{ __('List Description') }} ({{ __('optional') }})"></textarea>
                </div>

                <div class="form-group list-category dropdown-checkboxes-wrapper categories">
                    <div class="dropdown-checkboxes">
                        <span class="categories-selected">{{ __('Select a category') }} ({{ __('max') }} {{ setting('maximum-categories', 2) }})</span>
                        <span class="categories-selected-text hide">{{ __('Select a category') }} ({{ __('max') }} {{ setting('maximum-categories', 2) }})</span>
                        <span class="caret"></span>
                    </div>
                    <ul class="checkboxes-list" data-max-cat="{{ setting('maximum-categories', 2) }}">
                        @foreach ($categories as $category)
                            @if ( ! $category->template || $category->template == 'nsfw' || $category->template == 'meme')
                                <li>
                                    <label>{{ $category->title }}
                                        <input type="checkbox" name="categories[{{ $category->slug }}]" value="{{ $category->slug }}">
                                    </label>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

            </div> <!-- end of list-form -->

            <h2>{{ __('List Items') }}</h2>

            <div class="list-items-wrapper">
                <div class="list-item-container">
                    <div class="item-head">
                        <h3 class="heading">
                            <span class="item-counter">1</span>
                            <span class="number-abbr">st</span> {{ __('item') }}
                        </h3>
                        <div class="item-actions">
                            <button type="button" class="delete-item">delete item</button>
                            <button type="button" class="move-top">move top</button>
                            <button type="button" class="move-bottom">move bottom</button>
                        </div>
                    </div>
                    <div class="form-group item-upload">
                        <ul class="item-upload-tabs">
                            <li class="tab1 active">{{ __('Item from my computer') }}</li>
                            <li class="tab2">{{ __('Item from url') }}</li>
                        </ul>

                        <div class="item-upload-content media link">
                            <input type="file" name="items[0][media]" id="item-computer" class="tab1 active">
                            <input type="text" name="items[0][link]" id="item-url" class="tab2" placeholder="http://">
                        </div>
                    </div>

                    <div class="form-group title">
                        <label for="item-title" class="sr-only">Title</label>
                        <input type="text" name="items[0][title]" id="item-title" placeholder="{{ __('Title') }}">
                    </div>

                    <div class="form-group description">
                        <label for="item-description" class="sr-only">{{ __('Description') }} ({{ __('optional') }})</label>
                        <textarea name="items[0][description]" id="item-description" placeholder="{{ __('Description') }} ({{ __('optional') }})"></textarea>
                    </div>
                </div> <!-- end of list-item-container -->
            </div> <!-- end of list-items-wrapper -->

            <button type="button" class="btn-more-items">+ {{ __('one more item') }}</button>

            <div class="form-group post-list">
                <button type="submit" class="btn btn-medium make-list"><span>{{ __('Post List') }}</span></button>
            </div>
        </form>
    </div> <!-- end of make-list -->

@stop