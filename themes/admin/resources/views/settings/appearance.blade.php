@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings">
                    <div class="row">
                        <div class="col-md-6 m-b-lg border-right">
                            <div class="change-logo">
                            <h2 class="m-b-md">Change Logo</h2>
                            <form action="{{ route('admin.settings.appearance.logo') }}" enctype="multipart/form-data" class="form-inline clearfix" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group @if ($errors->has('logo')) has-error @endif">
                                    <label for="normalLogo" class="display-block">Normal Logo</label>
                                    <input type="file" name="logo" id="normalLogo" class="form-control">
                                    <button type="submit" class="btn btn-normal">Save</button>
                                </div>
                                <div class="form-group eg-logo-wrapper pull-right">
                                    @if (setting('logo'))
                                        <img src="{{ media(setting('logo')) }}" alt="Normal logo dimensions" class="normal-logo">
                                    @else
                                        <img src="{{ adminTheme('assets/img/settings-normal-logo.png') }}" alt="Normal logo dimensions" class="normal-logo">
                                    @endif
                                </div>
                                <div class="form-group logo-note display-block">
                                    @if ($errors->has('logo'))
                                        <span class="logo-note error">
                                            {{ $errors->first('logo') }}
                                        </span>
                                    @else
                                        <em class="logo-note">(Note: Orientative dimensions)</em>
                                    @endif
                                </div>
                            </form>
                            <form action="{{ route('admin.settings.appearance.logo') }}" enctype="multipart/form-data" method="post" class="form-inline clearfix" role="form">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group @if ($errors->has('mobile-logo')) has-error @endif">
                                    <label for="mobileLogo" class="display-block">Mobile Logo</label>
                                    <input type="file" name="mobile-logo" id="mobileLogo" class="form-control">
                                    <button type="submit" class="btn btn-normal">Save</button>
                                </div>
                                <div class="form-group eg-logo-wrapper pull-right">
                                    @if (setting('mobile-logo'))
                                        <img src="{{ media(setting('mobile-logo')) }}" alt="Normal logo dimensions" class="mobile-logo">
                                    @else
                                        <img src="{{ adminTheme('assets/img/settings-mobile-logo.png') }}" alt="Mobile logo dimensions" class="mobile-logo">
                                    @endif
                                </div>
                                <div class="form-group display-block">
                                    @if ($errors->has('mobile-logo'))
                                        <span class="logo-note">{{ $errors->has('mobile-error') }}</span>
                                    @else
                                        <em class="logo-note">(Note: This is optional)</em>
                                    @endif
                                </div>
                            </form>
                            <h2 class="m-b-md">Change Favicon</h2>
                            <form role="form" action="{{ route('admin.settings.appearance.favicon') }}" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group @if ($errors->has('favicon')) has-error @endif">
                                    <label for="favicon">Favicon</label>
                                    <input type="file" id="favicon" name="favicon" class="form-control">
                                    @if ($errors->has('favicon'))
                                        <span class="">{{ $errors->first('favicon') }}</span>
                                    @endif
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                            </div>
                        </div> <!-- end of change-logo -->
                        <div class="col-md-6 change-text">
                            <h2 class="m-b-md">Text Branding</h2>

                            <form action="{{ route('admin.settings.appearance.branding') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="title">Website Title</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ setting('branding.title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control">{{ setting('branding.description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Keywords</label>
                                    <textarea name="keywords" id="keywords" class="form-control">{{ setting('branding.keywords') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="copyrightText">Copyright Text</label>
                                    <input type="text" id="copyrightText" name="copyright" class="form-control" value="{{ setting('branding.copyright') }}">
                                </div>
                                <div class="form-group">
                                    <label for="urlFormat">Use friendly url</label>
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="video" @if (!setting('branding.slug', false)) checked @endif  data-url="{{ route('admin.settings.appearance.slug') }}">
                                            <label class="onoffswitch-label" for="video">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <em>eg: <b>My new post</b> will became <b>512-my-new-post</b></em>
                                </div>
                                <div class="form-group">
                                    <label for="urlFormat">Url Format</label>
                                    <input type="text" id="urlFormat" name="url-format" class="form-control" value="{{ setting('branding.url-format') }}">
                                    <em>eg: http://smile.com/smile/4F138LuY</em>
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of text-branding col -->
                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->

@stop