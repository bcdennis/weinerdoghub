@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings settings-social-media">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Gif conversions</h2>
                            <form class="pull-left" role="form">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="ffmpegOn" @if (!setting('conversion.on')) checked @endif>
                                        <label class="onoffswitch-label" for="ffmpegOn">
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
                                In nowadays there are formats that are working better than gif for bandwidth saving and media loading.
                            </p>
                            <p>
                                For this you can configure a ffmpeg service that will automatically convert gif to mp4 and webm.
                            </p>
                            <p>
                                Note: Shared hosting may not have ffmpeg access.
                            </p>
                        </div>
                    </div> <!-- end of row -->

                    <div class="row m-b-lg">
                        <div class="col-md-6">
                            <form action="{{ route('admin.settings.conversion.store') }}" class="m-b-md" role="form" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <div class="form-group">
                                    <label for="ffmpeg">FFMpeg</label> (path to the ffmpeg binary)
                                    <input type="text" id="ffmpeg" name="ffmpeg" class="form-control" value="{{ setting('conversion.binaries.ffmpeg', '/opt/ffmpeg/bin/ffmpeg') }}">
                                </div>
                                <div class="form-group">
                                    <label for="ffprobe">FFProbe</label> (path to the ffprobe binary)
                                    <input type="text" id="ffprobe" name="ffprobe" class="form-control" value="{{ setting('conversion.binaries.ffprobe', '/opt/ffmpeg/bin/ffprobe') }}">
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