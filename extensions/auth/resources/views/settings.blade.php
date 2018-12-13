@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                <div class="ibox-content settings">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Authentication With Social Media</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                In order to fully customize your website you need to make sure that when your users try to login via social media platforms, your site name will pop-up and not 'smile'.
                            </p>
                            <p>
                                In order to do that, please visit <a href="https://developers.facebook.com/docs/facebook-login/v2.4" target="_blank" class="text-danger">facebook developers</a> and <a href="https://console.developers.google.com/start" target="_blank" class="text-danger">google developers</a> pages to make your own login application and insert the id's they provide to you in the forms down below.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-6 border-right">
                            <h2>Facebook</h2>
                            <form action="{{ route('admin.extensions.auth.facebook') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="fbClientId">Client ID</label>
                                    <input type="text" name="client_id" id="fbClientId" class="form-control"  value="{{ perm('demo') ? 'demo is not allowed' : setting('auth.facebook.client_id') }}">
                                </div>
                                <div class="form-group">
                                    <label for="fbClientSecret">Client Secret</label>
                                    <input type="text" name="client_secret" class="form-control" id="fbClientSecret"  value="{{ perm('demo') ? 'demo is not allowed' : setting('auth.facebook.client_secret') }}">
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of facebook col -->
                        <div class="col-md-6">
                            <h2>Google+</h2>
                            <form action="{{ route('admin.extensions.auth.google') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="gpClientId">Client ID</label>
                                    <input type="text" name="client_id" id="gpClientId" class="form-control" value="{{ perm('demo') ? 'demo is not allowed' : setting('auth.google.client_id') }}">
                                </div>
                                <div class="form-group">
                                    <label for="gpClientSecret">Client Secret</label>
                                    <input type="text" name="client_secret" class="form-control" id="gpClientSecret" value="{{ perm('demo') ? 'demo is not allowed' : setting('auth.google.client_secret') }}">
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of g+ col -->
                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop