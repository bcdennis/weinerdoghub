@extends('installer::app')

@section('content')
    <form class="clearfix" role="form" action="{{ route('admin') }}" method="post" id="user-form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="step-content">
            <div class="center">
                <h2 class="m-b-lg">It's time to setup your admin account.</h2>
                @if ( ! session('install.admin.user') && !session('just-update'))
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Username</label>
                            <input type="text" name="name" id="name" class="form-control">
                            @if ($errors->has('name'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            @if ($errors->has('email'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @if ($errors->has('password'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                @else
                    @if (session('just-update'))
                        <p class="m-b-lg">You are just updating the app. You may go to the next step.</p>
                    @else
                        <p class="m-b-lg">Your account was already created! Username is: {{ session('install.admin.username') }}</p>
                    @endif
                @endif
            </div>
        </div> <!-- end of step-content -->
        <div class="pull-right m-b-custom">
            <a href="{{ route('email') }}" class="btn btn-sm btn-danger">Previous</a>
            @if ( ! session('install.admin.user'))
                <button type="submit" class="btn btn-sm btn-danger">Next</button>
            @else
                <a href="{{ route('finish') }}" class="btn btn-sm btn-danger">Next</a>
            @endif
        </div>
    </form>
@stop