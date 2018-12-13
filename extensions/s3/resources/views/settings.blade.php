@extends('admin::app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="container">
        <div class="ibox">
            <div class="ibox-content settings settings-social-media">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="pull-left">Cloud storage</h2>
                    </div>
                </div> <!-- end of row -->
                <div class="row m-b-lg">
                    <div class="col-md-12">
                        <p>
                            Smile allows you to host your uploaded files in the cloud without hassle. You must create an Amazon S3 account and
                            fill this form and you're ready to go.
                        </p>
                        <p>
                            Attention: You must move your local uploads directory to the amazon bucket if you want the old
                            images to work!
                        </p>
                    </div>
                </div> <!-- end of row -->

                <div class="row m-b-lg">
                    <div class="col-md-12">
                        <form class="m-b-md" role="form" method="post" action="{{ route('admin.extensions.s3.settings') }}">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group @if($errors->has('key')) has-error @endif">
                                <label for="key">Aws Key</label>
                                <input type="text" name="key" id="key" value="{{ perm('demo') ? 'demo is not allowed' : setting('extensions.s3.key') }}" class="form-control">
                            </div>
                            <div class="form-group @if($errors->has('secret')) has-error @endif">
                                <label for="secret">Aws Secret</label>
                                <input type="text" name="secret" id="secret" value="{{ perm('demo') ? 'demo is not allowed' : setting('extensions.s3.secret') }}" class="form-control">
                            </div>
                            <div class="form-group @if($errors->has('bucket')) has-error @endif">
                                <label for="bucket">Bucket</label>
                                <input type="text" name="bucket" id="bucket" value="{{ setting('extensions.s3.bucket') }}" class="form-control">
                            </div>
                            <div class="form-group @if($errors->has('region')) has-error @endif">
                                <label for="region">Region</label>
                                <input type="text" name="region" id="region" value="{{ setting('extensions.s3.region') }}" class="form-control">
                            </div>
                            <div class="form-group @if($errors->has('url')) has-error @endif">
                                <label for="url">Public URL</label>
                                <input type="text" name="url" id="url" value="{{ setting('extensions.s3.url') }}" class="form-control">
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