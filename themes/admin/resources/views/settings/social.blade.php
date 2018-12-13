@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings settings-social-media">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Social Media Plugin</h2>
                            <form class="pull-left" role="form">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="adsOnOff" @if (!setting('social.on')) checked @endif>
                                        <label class="onoffswitch-label" for="adsOnOff">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                If you don't what the social media plugin on your website just hit that switch button.
                            </p>
                            <p>
                                But, if you want it, make sure it's on and put your social media links in the forms down below.
                            </p>
                        </div>
                    </div> <!-- end of row -->

                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <form action="{{ route('admin.settings.social.facebook') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="socialFacebook">Facebook</label> (full url to page or username)
                                    <textarea name="url" id="socialFacebook" class="form-control" placeholder="bitempest">{{ setting('social.facebook') }}</textarea>
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <form action="{{ route('admin.settings.social.twitter') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="socialTwitter">Twitter</label>
                                    <textarea name="name" id="socialTwitter" placeholder="bitempest" class="form-control">{{ setting('social.twitter.name') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="socialTwitter">Twitter Widget Id</label>
                                    <textarea name="widget" id="socialTwitter" placeholder="622736712314277888" class="form-control">{{ setting('social.twitter.widget') }}</textarea>
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.settings.social.google') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="socialGplus">Google+</label>
                                    <textarea name="url" id="socialGplus" placeholder="113150176157103865974" class="form-control">{{ setting('social.google') }}</textarea>
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                        </div>
                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop