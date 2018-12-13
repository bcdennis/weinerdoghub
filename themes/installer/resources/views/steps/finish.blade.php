@extends('installer::app')

@section('content')
    <form class="clearfix" role="form" action="{{ route('finish') }}" method="post" id="finish-from">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="step-content">
            <div class="center">
                <h2>
                    It looks like you are good to go :)
                </h2>
                <p>
                    Now you should choose if you'll use this install in development mode or production mode.
                    In production mode errors are hidden from the viewers. Also, after this step, we'll populate your
                    database with some default settings. You may want to change them.
                </p>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="dev" value="1"> Enable development mode <small>(optional)</small>
                        </label>
                    </div>
            </div>
        </div> <!-- end of step-content -->
        <div class="text-center">
            <button type="submit" class="btn btn-sm btn-danger finish-btn">Finish</button>
        </div>
    </form>
@stop
