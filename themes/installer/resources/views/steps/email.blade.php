@extends('installer::app')

@section('content')
<form class="clearfix" role="form" action="{{ route('email') }}" method="post" id="email-form">
    <div class="step-content">
        <div class="center">
            <h2>
                Email server used by contact form and account confirmation.
            </h2>
            <p>
                This is the email where all messages sent by users via the contact form and account confirmations will be sent.
            </p>
            <p class="m-b-lg">
                This is optional but if you skip this step your users will no longer be able to send emails and also they will no longer receive account confirmations.
            </p>
            <p class="m-b-lg">
                Atention! If you choose PHP Mail, you will only need to fill Sender Name, Sender Email and Support Email!
            </p>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group @if ($errors->has('driver')) has-error @endif">
                    <label for="driver">SMTP Driver</label>
                    <select name="driver" id="driver" class="form-control">
                        <option value="mail">PHP Mail</option>
                        <option value="smtp">SMTP</option>
                    </select>
                    @if ($errors->has('driver'))
                        <span class="help-block text-danger">
                            {{ $errors->first('driver') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('host')) has-error @endif">
                    <label for="host">SMTP Host</label>
                    <input type="text" name="host" id="host" placeholder="eg: smtp.gmail.com" class="form-control">
                    @if ($errors->has('host'))
                        <span class="help-block text-danger">
                            {{ $errors->first('host') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('port')) has-error @endif">
                    <label for="port">SMTP Port</label>
                    <input type="text" name="port" id="port" placeholder="eg: 465" class="form-control">
                    @if ($errors->has('host'))
                        <span class="help-block text-danger">
                            {{ $errors->first('host') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('username')) has-error @endif">
                    <label for="username">SMTP Username</label>
                    <input type="text" name="username" id="username" placeholder="eg: some-email@gmail.com" class="form-control">
                    @if ($errors->has('username'))
                        <span class="help-block text-danger">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    <label for="password">SMTP Password</label>
                    <input type="password" name="password" id="password" placeholder="eg: email password" class="form-control">
                    @if ($errors->has('password'))
                        <span class="help-block text-danger">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('sender-email')) has-error @endif">
                    <label for="sender-email">Sender Email (eg: contact@smile.com)</label>
                    <input type="text" name="sender-email" id="sender-email" placeholder="eg: some-email@gmail.com" class="form-control">
                    @if ($errors->has('sender-email'))
                        <span class="help-block text-danger">
                            {{ $errors->first('sender-email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('sender-name')) has-error @endif">
                    <label for="sender-name">Sender Name (eg: SmileApp)</label>
                    <input type="text" name="sender-name" id="sender-name" placeholder="eg: SmileApp" class="form-control">
                    @if ($errors->has('sender-name'))
                        <span class="help-block text-danger">
                            {{ $errors->first('sender-name') }}
                        </span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('support')) has-error @endif">
                    <label for="support">Contact Support Email</label>
                    <input type="text" name="support" id="support" placeholder="eg: contact@smile.com" class="form-control">
                    @if ($errors->has('support'))
                        <span class="help-block text-danger">
                            {{ $errors->first('support') }}
                        </span>
                    @endif
                </div>
        </div>
    </div> <!-- end of step-content -->
    <div class="pull-right m-b-custom">
        <a href="{{ route('database') }}" class="btn btn-sm btn-danger">Previous</a>
        <button type="submit" class="btn btn-sm btn-danger">Next</button>
        <a href="{{ route('admin') }}" class="btn btn-sm btn-danger">Skip >></a>
    </div>
</form>
@stop
