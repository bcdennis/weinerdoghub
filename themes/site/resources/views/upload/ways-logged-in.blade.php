<div class="upload-ways dropdown">
    <ul>
        <li>
            <a href="#" class="modal-trigger" data-target=".modal-upload-file">{{ __('from my computer') }}</a>
        </li>
        <li>
            <a href="#" class="modal-trigger" data-target=".modal-upload-url">{{ __('from URL') }}</a>
        </li>
        <li><a href="{{ route('posts.list') }}">{{ __('Make a list') }}</a></li>
        @widget('upload-ways.logged-in')
    </ul>
</div> <!-- end of upload-ways -->
