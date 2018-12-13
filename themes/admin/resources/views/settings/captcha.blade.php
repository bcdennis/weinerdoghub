@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings settings-ads">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Recapthca Settings</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                We highly recommend that you enable the captcha we provide to stop the bots spamming attacks.
                            </p>
                            <p>
                                Go to <a target="_blank" class="text-danger" href="https://www.google.com/recaptcha/intro/index.html">Google Recaptcha</a> and generate a site key and a
                                secret key. Don't forget to wildcard your domain in the captcha admin panel for it to work.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-6">
                            <form class="m-b-md" role="form" action="{{ route('admin.settings.captcha') }}" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="siteKey">Site Key</label>
                                    <input type="text" name="key" id="siteKey" value="{{ perm('demo') ? 'demo is not allowed' : setting('captcha.key') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="secretKey">Secret Key</label>
                                    <input type="text" name="secret" value="{{ perm('demo') ? 'demo is not allowed' : setting('captcha.secret') }}" class="form-control" id="secretKey">
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