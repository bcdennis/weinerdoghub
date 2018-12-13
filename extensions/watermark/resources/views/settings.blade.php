@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                <div class="ibox-content settings">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Watermark system</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                This module provides you the ability to add an watermark on media files before uploading them to the server.
                            </p>
                            <p>
                                In order for it to work you must upload a watermark file in the png format.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">

                            <form class="form-inline clearfix set-watermark" enctype="multipart/form-data" role="form" method="post" action="{{ route('admin.extensions.watermark.settings') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group @if ($errors->has('watermark')) has-error @endif">
                                    <label for="watermark" class="display-block">Watermark Image</label>
                                    <input type="file" id="watermark" name="watermark" class="form-control">
                                    @if ($errors->has('watermark'))
                                        <span>{{ $errors->first('watermark') }}</span>
                                    @endif
                                </div>
                                <div class="form-group eg-watermark-wrapper pull-right">
                                    @if (setting('watermark.image'))
                                        <img src="{{ media(setting('watermark.image')) }}" alt="watermark image" class="watermark">
                                    @endif
                                </div>
                                <div class="form-group watermark-position">
                                    <label for="position" class="display-block">Watermark Position</label>
                                    <select name="position" id="position" class="form-control">
                                        <option @if (setting('watermark.position') == 'top-left') selected @endif value="top-left">top-left</option>
                                        <option @if (setting('watermark.position') == 'top') selected @endif  value="top">top-center</option>
                                        <option @if (setting('watermark.position') == 'top-right') selected @endif  value="top-right">top-right</option>
                                        <option @if (setting('watermark.position') == 'left') selected @endif  value="left">center-left</option>
                                        <option @if (setting('watermark.position') == 'center') selected @endif  value="center">center</option>
                                        <option @if (setting('watermark.position') == 'right') selected @endif  value="right">center-right</option>
                                        <option @if (setting('watermark.position') == 'bottom-left') selected @endif  value="bottom-left">bottom-left</option>
                                        <option @if (setting('watermark.position') == 'bottom') selected @endif  value="bottom">bottom-center</option>
                                        <option @if (setting('watermark.position') == 'bottom-right') selected @endif  value="bottom-right">bottom-right</option>
                                    </select>
                                </div>
                                <div class="form-group  watermark-position">
                                    <label for="x" class="display-block">Position offset X</label>
                                    <input type="text" id="x" name="x" placeholder="0" value="{{ setting('watermark.offset.x', 0) }}" class="help-block form-control" />
                                    @if ($errors->has('x'))
                                        <span>{{ $errors->first('x') }}</span>
                                    @endif
                                </div>
                                <div class="form-group  watermark-position">
                                    <label for="y" class="display-block">Position offset Y</label>
                                    <input type="text" id="y" name="y" placeholder="0" value="{{ setting('watermark.offset.y', 0) }}" class="help-block form-control" />
                                    @if ($errors->has('y'))
                                        <span>{{ $errors->first('y') }}</span>
                                    @endif
                                </div>
                                <div class="form-group  watermark-position">
                                    <label for="rotation" class="display-block">Rotation (degree)</label>
                                    <input type="text" id="rotation" name="rotation" placeholder="0" value="{{ setting('watermark.rotation', 0) }}" class="help-block form-control" />
                                    @if ($errors->has('rotation'))
                                        <span>{{ $errors->first('rotation') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of facebook col -->

                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop