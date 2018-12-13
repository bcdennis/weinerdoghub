@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings">
                    <div class="row">
                        <div class="col-md-6 size-restrictions border-right">
                            <h2 class="m-b-md">Image Settings</h2>
                            <div class="img-restrictions">
                                <form class="m-b-lg" role="form"  method="post" action="{{ route('admin.settings.restrictions') }}">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="form-group">
                                        <label for="imageSize">Upload Image Max-Size (kb)</label>
                                        <input type="text" id="imageSize" name="image-size" class="form-control" value="{{ setting('image-size') }}">
                                    </div>
                                    <button class="btn btn-normal">Save</button>
                                </form>
                                <form class="m-b-lg" role="form"  method="post" action="{{ route('admin.settings.restrictions') }}">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="form-group">
                                        <label for="avatarSize">Avatar Max-Size (kb)</label>
                                        <input type="text" id="avatarSize" name="avatar-size" class="form-control" value="{{ setting('avatar-size') }}">
                                    </div>
                                    <button class="btn btn-normal">Save</button>
                                </form>
                                <form class="m-b-lg" role="form"  method="post" action="{{ route('admin.settings.restrictions') }}">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="form-group">
                                        <label for="avatarSize">Video posts</label>
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" class="onoffswitch-checkbox" id="video" @if (!setting('videoPost', true)) checked @endif  data-url="{{ route('admin.settings.restrictions.video') }}">
                                                <label class="onoffswitch-label" for="video">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <h2 class="m-b-md">Post Title Size</h2>
                            <form class="m-b-lg" role="form"  method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="postTitle">Title Size (number of characters)</label>
                                    <input type="text" id="postTitle" name="post-size" class="form-control" value="{{ setting('post-size') }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>

                            <h2 class="m-b-md">Lists</h2>
                            <form class="m-b-lg" role="form"  method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="max-list-items">Maximum number of list items</label>
                                    <input type="text" id="max-list-items" name="max-list-items" class="form-control" value="{{ setting('max-list-items', 10) }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>

                            <h2 class="m-b-md">Comment interval time</h2>
                            <form class="m-b-lg" role="form"  method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="postTitle">Time between comments (in seconds)</label>
                                    <input type="text" id="postTitle" name="comment-interval" class="form-control" value="{{ setting('comment-interval', 0) }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>

                            <h2 class="m-b-md">Registration</h2>
                            <form class="m-b-lg" role="form"  method="post" action="#">
                                <div class="form-group">
                                    <label for="registration">Status</label>
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="registration" @if (!setting('registration', true)) checked @endif  data-url="{{ route('admin.settings.restrictions.register') }}">
                                            <label class="onoffswitch-label" for="registration">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <h2 class="m-b-md">Post moderation</h2>
                            <form class="m-b-lg" role="form"  method="post" action="#">
                                <div class="form-group">
                                    <label for="post-moderation">Status</label>
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="post-moderation" @if (!setting('post-moderation', false)) checked @endif  data-url="{{ route('admin.settings.restrictions.post-moderation') }}">
                                            <label class="onoffswitch-label" for="post-moderation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end of size-restrictions -->
                        <div class="col-md-6 lvl-up">
                            <h2 class="m-b-md">Number of Smiles to Level Up</h2>
                            <form class="form-inline" role="form" method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="bronzeLvl" class="label-lvl bronze-lvl">
                                        <img src="{{ adminTheme('assets/img/bronze.png') }}" alt="Bronze Lvl Badge">
                                        <span>Bronze</span>
                                    </label>
                                    <input type="text" id="bronzeLvl" name="bronze-lvl" class="form-control" value="{{ setting('bronze-lvl') }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                            <form class="form-inline" role="form" method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="silverLvl" class="label-lvl silver-lvl">
                                        <img src="{{ adminTheme('assets/img/silver.png') }}" alt="Silver Lvl Badge">
                                        <span>Silver</span>
                                    </label>
                                    <input type="text" id="silverLvl" name="silver-lvl" class="form-control" value="{{ setting('silver-lvl') }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                            <form class="form-inline" role="form" method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="goldLvl" class="label-lvl gold-lvl">
                                        <img src="{{ adminTheme('assets/img/gold.png') }}" alt="Gold Lvl Badge">
                                        <span>Gold</span>
                                    </label>
                                    <input type="text" id="goldLvl" name="gold-lvl" class="form-control" value="{{ setting('gold-lvl') }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                            <form class="form-inline" role="form" method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="platinumLvl" class="label-lvl platinum-lvl">
                                        <img src="{{ adminTheme('assets/img/platinum.png') }}" alt="Platinum Lvl Badge">
                                        <span>Platinum</span>
                                    </label>
                                    <input type="text" id="platinumLvl" name="platinum-lvl" class="form-control" value="{{ setting('platinum-lvl') }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>

                            <h2 class="m-b-md">Number of categories per post</h2>
                            <form role="form" method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="numberCat">Number of Categories</label>
                                    <input type="text" id="numberCat" name="maximum-categories" class="form-control" value="{{ setting('maximum-categories', 2) }}">
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>

                            <h2 class="m-b-md">Default language</h2>
                            <form role="form" method="post" action="{{ route('admin.settings.restrictions') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="position" class="display-block">Language</label>
                                    <select name="language" id="position" class="form-control">
                                        @foreach (languages() as $lang)
                                            <option @if (setting('language') == $lang) selected @endif value="{{ $lang }}">{{ $lang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>

                            </div>
                        </div> <!-- end of lvl-up -->
                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop