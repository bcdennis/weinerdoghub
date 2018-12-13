@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings settings-comments">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Comments</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                Select what types of comments you want on your site. If you don't want comments at all turn off all of them.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-6">
                            <table class="table table-hover">
                                <tr>
                                    <td>Default Comments (smile comments)</td>
                                    <td>
                                        <form class="pull-left" role="form">
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" class="onoffswitch-checkbox" id="defaultComments"  @if (!setting('comments.local.on', true)) checked @endif data-url="{{ route('admin.settings.comments.local') }}">
                                                    <label class="onoffswitch-label" for="defaultComments">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>Facebook Comments</span>
                                        <form method="post" class="disqus-form form-inline" action="{{ route('admin.settings.comments.fb.id') }}">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="form-group">
                                                <label for="idFb">Id</label>
                                                <input type="text" id="idFb" name="id" value="{{ setting('comments.fb.id') }}">
                                            </div>
                                            <button class="">save</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="pull-left" role="form">
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" class="onoffswitch-checkbox" id="fbComments" @if (!setting('comments.facebook.on')) checked @endif data-url="{{ route('admin.settings.comments.facebook') }}">
                                                    <label class="onoffswitch-label" for="fbComments">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>Disqus Comments</span>
                                        <form method="post" class="disqus-form form-inline" action="{{ route('admin.settings.comments.disqus.id') }}">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="form-group">
                                                <label for="idDisqus">Id</label>
                                                <input type="text" id="idDisqus" name="id" value="{{ setting('comments.disqus.id') }}">
                                            </div>
                                            <button class="">save</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="pull-left" role="form">
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" class="onoffswitch-checkbox" id="disqusComments" @if (!setting('comments.disqus.on')) checked @endif data-url="{{ route('admin.settings.comments.disqus') }}">
                                                    <label class="onoffswitch-label" for="disqusComments">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop