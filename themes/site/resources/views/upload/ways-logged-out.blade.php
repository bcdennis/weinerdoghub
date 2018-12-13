<div class="upload-ways dropdown">
    <ul>
        <li>
            <a href="#" class="modal-trigger" data-target=".modal-log-in">{{ __('from my computer') }}</a>
        </li>
        <li>
            <a href="#" class="modal-trigger" data-target=".modal-log-in">{{ __('from URL') }}</a>
        </li>
        <li><a href="#" class="modal-trigger" data-target=".modal-log-in">{{ __('Make a list') }}</a></li>
        @widget('upload-ways.logged-out')
    </ul>
</div> <!-- end of upload-ways -->