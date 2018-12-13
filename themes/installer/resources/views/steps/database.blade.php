@extends('installer::app')

@section('content')
<form class="clearfix" id="database-form" role="form" action="{{ route('database.check') }}" method="post">
    <div class="step-content">
    <div class="center">
        <h2 class="m-b-lg">The place where Smile will dwell.</h2>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            @if ($errors->has('general'))
                <p class="text-danger db-error">Provided credentials are invalid!</p>
            @endif
            <div class="form-group @if ($errors->has('host')) has-error @endif">
                <label for="host">Host</label>
                <input type="text" name="host" id="host" value="localhost" class="form-control">
                @if ($errors->has('host'))
                    <span class="help-block text-danger">
                        {{ $errors->first('host') }}
                    </span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('username')) has-error @endif">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control">
                @if ($errors->has('username'))
                    <span class="help-block text-danger">
                        {{ $errors->first('username') }}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group @if ($errors->has('database')) has-error @endif">
                <label for="dbName">DB Name</label>
                <input type="text" name="database" id="dbName" class="form-control">
                @if ($errors->has('database'))
                    <span class="help-block text-danger">
                        {{ $errors->first('database') }}
                    </span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('port')) has-error @endif">
                <label for="port">Port</label>
                <input type="text" name="port" id="port" value="3306" class="form-control">
                @if ($errors->has('port'))
                    <span class="help-block text-danger">
                        {{ $errors->first('port') }}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="update" value="1"> This is just an update <small>(database will remain unchanged)</small>
                </label>
            </div>
        </div>
    </div> <!-- end of step-content -->
    <div class="pull-right m-b-custom">
        <button href="{{ route('email') }}" class="btn btn-sm btn-danger next-btn">Next</button>
    </div>
</form>

@stop
