@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings settings-analytics">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Analytics</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                If you want to keep track of all activities on your site, please copy the code received from your analytic app in the form down below.
                            </p>
                        </div>
                    </div> <!-- end of row -->

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.settings.analytics') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="analytics">Paste the code here</label>
                                    <textarea name="value" rows="10" id="analytics" class="form-control">{{ setting('analytics.code') }}</textarea>
                                </div>
                                <button class="btn btn-normal">Save</button>
                            </form>
                        </div>
                    </div> <!-- end of analytics row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->

@stop