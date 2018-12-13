@extends('admin::app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="container">
        <div class="ibox">
            <div class="ibox-title">
                <h5>License and News</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        @if ( ! $valid)
                            <div class="alert alert-danger">
                                <span class="fa fa-minus-circle"></span>
                                It looks like you didn't activate the app. Before starting to use it you have to enter the license.
                            </div>
                        @endif

                        @if ($latestVersion != '0.0.0' && $currentVersion != $latestVersion)
                            <div class="alert alert-warning">
                                <span class="fa fa-warning"></span>
                                You're using smile v{{ $currentVersion }} but <strong>v{{ $latestVersion }}</strong> has been released, click <a href="http://codecanyon.net/item/smile-media-an-entertainment-viral-platform/12613909" target="_blank">here</a> to see what's new.
                            </div>
                        @endif
                    </div>
                </div> <!-- end of row -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="{{ route('admin.license') }}" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            @if ($valid)
                                <div class="form-group has-success">
                                    <label for="license">License</label>
                                    <div class="input-group">
                                        <input type="text" name="license" id="license" class="form-control" value="{{ perm('demo') ? 'hidden in demo account' : $current }}">
                                        <span class="input-group-addon">
                                            <span class="fa fa-check"></span>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="form-group has-error">
                                    <label for="license">License</label>
                                    <div class="input-group">
                                        <input type="text" name="license" id="license" class="form-control" placeholder="e.g: 3a7fg77vdG4F8fgh58HD330">
                                        <span class="input-group-addon">
                                            <span class="fa fa-exclamation"></span>
                                        </span>
                                    </div>
                                </div>
                            @endif
                            @if ( ! $valid)
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Activate</button>
                                </div>
                            @endif
                        </form>
                    </div> <!-- end of col-md-6 -->
                </div> <!-- end of row -->
            </div> <!-- end of ibox-content -->
        </div> <!-- end of ibox -->
    </div> <!-- end of container -->
</div> <!-- end of wrapper wrapper-content -->
@stop