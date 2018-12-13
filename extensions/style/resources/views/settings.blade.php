@extends('admin::app')

@section('css')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/codemirror.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/addon/hint/show-hint.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/theme/monokai.min.css"/>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/mode/css/css.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/addon/hint/show-hint.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/addon/edit/matchbrackets.min.js"></script>
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("css"), {
            extraKeys: {"Ctrl-Space": "autocomplete"},
            theme: "monokai",
            matchBrackets: true
        });
    </script>
@stop

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                <div class="ibox-content settings settings-ads">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="pull-left">Style your app</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                With this module you can override your app css by using your own css.
                            </p>
                            <p>
                                For testing purposes you can enable the styling only for the admins.
                            </p>
                            <p>
                                Keep in mind that you may need to use !important to override the css.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12 border-right">
                            <h2>Your css code</h2>
                            <form class="m-b-lg" role="form" method="post" action="{{ route('admin.extensions.style.settings') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="css">Remember to enter valid css</label>
                                    <textarea name="css" id="css" rows="15" class="form-control">{{ setting('style.css', '') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div> <!-- end of square ads col -->

                    </div> <!-- end of ads row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop