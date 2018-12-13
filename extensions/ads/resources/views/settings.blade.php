@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                <div class="ibox-content settings settings-ads">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Ads</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                If you want no ads on your website just click that switch button.
                            </p>
                            <p>
                                By default you will have those 'space for ads' ads. If you want to add an ad using a provider you can paste the code from them in forms on the left side, or if you designed your own ad you can use the forms from the right.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-6 border-right">
                            <h2>Square Ads</h2>
                            <form class="m-b-lg" role="form" method="post" action="{{ route('admin.extensions.ads.settings') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="squareAdsProvider">Square Ads via Provider</label>
                                    <textarea name="square-ad-code" id="squareAdsProvider" class="form-control">{{ setting('square-ad-code', '') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                            <form role="form" method="post" action="{{ route('admin.extensions.ads.settings.upload') }}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="mySquareAds">My Square Ad</label>
                                    <input type="file" name="square-ad-image" class="form-control" id="mySquareAds">
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of square ads col -->
                        <div class="col-md-6">
                            <h2>Rectangle Ads</h2>
                            <form class="m-b-lg" role="form" method="post" action="{{ route('admin.extensions.ads.settings') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="rectangleAdsProvider">Rectangle Ads via Provider</label>
                                    <textarea name="rectangle-ad-code" id="rectangleAdsProvider" class="form-control">{{ setting('rectangle-ad-code', '') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                            <form role="form" method="post" action="{{ route('admin.extensions.ads.settings.upload') }}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="myRectangleAds">My Rectangle Ad</label>
                                    <input type="file" name="rectangle-ad-image" class="form-control" id="myRectangleAds">
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of rectangle ads col -->
                    </div> <!-- end of ads row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop