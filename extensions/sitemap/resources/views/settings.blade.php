@extends('admin::app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="container">
        <div class="ibox">
            <div class="ibox-content settings settings-social-media">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="pull-left">Sitemap Generator</h2>
                    </div>
                </div> <!-- end of row -->
                <div class="row m-b-lg">
                    <div class="col-md-12">
                        <p>
                            Having a lot of links into your site usually means more work for search engines when they crawl for the pages.
                        </p>
                        <p>
                            The sitemap generator allow crawlers to find all the generated links from the site.
                        </p>
                    </div>
                </div> <!-- end of row -->

                <div class="row m-b-lg">
                    <div class="col-md-12">

                        <form class="m-b-md" role="form" method="post" action="{{ route('admin.extensions.sitemap.settings') }}">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <button class="btn btn-normal">Regenerate</button>
                            </div>
                            <div class="form-group">
                                @if (session()->has('sitemap'))
                                    <span>Sitemap regenerated in /sitemap.xml!</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div> <!-- end of row -->

            </div> <!-- end of ibox-content -->
        </div> <!-- end of ibox -->
    </div> <!-- end of container -->
</div> <!-- end of wrapper wrapper-content -->
@stop