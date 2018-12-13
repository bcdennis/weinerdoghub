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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/mode/javascript/javascript.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/addon/hint/show-hint.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/addon/edit/matchbrackets.min.js"></script>
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("javascript"), {
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
                            <h2 class="pull-left">Add JS to your app</h2>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12">
                            <p>
                                With this module you can your own javascript code to your app allowing you to make changes
                                without editing the files.
                            </p>
                        </div>
                    </div> <!-- end of row -->
                    <div class="row m-b-lg">
                        <div class="col-md-12 border-right">
                            <h2>Javascript code</h2>
                            <form class="m-b-lg" role="form" method="post" action="{{ route('admin.extensions.javascript.settings') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="javascript">Bad code may produce errors. Check the browser console after!</label>
                                    <textarea name="javascript" id="javascript" rows="15" class="form-control">{{ setting('javascript', '') }}</textarea>
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