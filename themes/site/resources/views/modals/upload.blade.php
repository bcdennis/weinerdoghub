<div class="modal modal-upload modal-upload-url">
    <button class="modal-close"><span>x</span></button>
    <h2 class="modal-heading">{{ __('Upload via URL') }}</h2>
    <p class="modal-subheading">{{ __('formats accepted:') .' '. ('images and also videos') }}</p>
    <form action="{{ route('posts.store.url') }}" method="post" id="url-upload-form">
        <div class="form-group link">
            <label for="url-link" class="sr-only">{{ __('Link') }}</label>
            <input type="text" name="link" placeholder="http://" id="url-link">
        </div>
        <div class="form-group title">
            <label for="url-title" class="sr-only">{{ __('Title') }}</label>
            <textarea name="title" class="post-title" id="url-title" placeholder="{{ __('Title') }}"></textarea>
        </div>

        <div class="form-group dropdown-checkboxes-wrapper categories">
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
        <div class="form-group post-description description hide">
            <label for="url-description" class="sr-only">{{ __('Description') }}</label>
            <textarea name="description" id="url-description" placeholder="{{ __('Description') }}"></textarea>
        </div>
        <div class="upload-footer">
            <label>
                <input type="checkbox" class="description-checkbox" name="desc">
                {{ __('Add description') }}
            </label>
            <button type="submit" class="btn btn-upload">
                <span>{{ __('Upload') }}</span>
            </button>
        </div>
    </form>
</div> <!-- end of modal-upload-file -->

<div class="modal modal-upload modal-upload-file">
    <button class="modal-close"><span>x</span></button>
    <h2 class="modal-heading">{{ __('Upload') }}</h2>
    <p class="modal-subheading">{{ __('formats accepted:') }} GIF, JPG, PNG ({{ __('max') }} {{ number_format(setting('image-size', 3072) / 1000, 0) }}mb)</p>

    <form action="{{ route('posts.store.file') }}" method="post" id="file-upload-form" enctype="multipart/form-data">
        <div class="form-group media">
            <label for="media" class="sr-only">{{ __('Choose File') }}</label>
            <input type="file" name="media" id="media">
        </div>
        <div class="form-group title">
            <label for="file--title" class="sr-only">{{ __('Title') }}</label>
            <textarea name="title" class="post-title" id="file-title" placeholder="{{ __('Title') }}"></textarea>
        </div>
        <div class="form-group dropdown-checkboxes-wrapper categories">
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
        <div class="form-group post-description description hide">
            <label for="file-description" class="sr-only">{{ __('Description') }}</label>
            <textarea name="description" id="file-description" placeholder="{{ __('Description') }}"></textarea>
        </div>
        <div class="upload-footer">
            <label>
                <input type="checkbox" class="description-checkbox" name="originalCreator">
                {{ __('Add description') }}
            </label>
            <button type="submit" class="btn btn-upload">
                <span>{{ __('Upload') }}</span>
            </button>
        </div>
    </form>
</div> <!-- end of modal-upload-url -->
