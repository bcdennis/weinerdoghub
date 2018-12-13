@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                @include('admin::partials.settings-nav')
                <div class="ibox-content settings settings-ads">
                    <div class="row m-b-lg">
                        <div class="col-md-6 border-right">
                            <h2>Email Server Settings</h2>
                            <p class="m-b-lg">
                                You should configure the email delivery settings. You can use
                                gmail (up to 200 emails per day), your own smtp server or paid email services.
                            </p>
                            <form class="m-b-md" role="form" method="post" action="{{ route('admin.settings.email') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group @if($errors->has('driver')) has-error @endif">
                                    <label for="driver">Mail driver</label> (If you chose php mail, there is no need to fill smtp configs)
                                    <select name="driver" id="driver" class="form-control">
                                        <option @if(setting('email.driver', 'mail') == 'mail') selected @endif value="mail">PHP MAIL Function</option>
                                        <option @if(setting('email.driver', 'mail') == 'smtp') selected @endif  value="smtp">SMTP</option>
                                    </select>
                                </div>
                                <div class="form-group @if($errors->has('encryption')) has-error @endif">
                                    <label for="encryption">SMTP Encryption</label>
                                    <input type="text" name="encryption" id="encryption" value="{{ setting('email.encryption', 'ssl') }}" class="form-control">
                                </div>
                                <div class="form-group @if($errors->has('host')) has-error @endif">
                                    <label for="host">SMTP Host</label>
                                    <input type="text" name="host" id="host" value="{{ setting('email.host') }}" class="form-control">
                                </div>
                                <div class="form-group @if($errors->has('user')) has-error @endif">
                                    <label for="username">SMTP Username</label>
                                    <input type="text" name="user" value="{{ perm('demo') ? 'demo is not allowed' : setting('email.user') }}" class="form-control" id="username">
                                </div>
                                <div class="form-group @if($errors->has('port')) has-error @endif">
                                    <label for="port">SMTP Port</label>
                                    <input type="text" name="port" value="{{ setting('email.port') }}" class="form-control" id="port">
                                </div>
                                <div class="form-group @if($errors->has('pass')) has-error @endif">
                                    <label for="password">SMTP Password</label>
                                    <input type="password" name="pass" value="{{ perm('demo') ? 'demo is not allowed' :  setting('email.pass') }}" class="form-control" id="password">
                                </div>
                                <div class="form-group @if($errors->has('sender-email')) has-error @endif">
                                    <label for="sender-email">Sender Email (eg: no-reply@smile.com)</label>
                                    <input type="text" name="sender-email" value="{{ setting('email.sender-email') }}" class="form-control" id="password">
                                </div>
                                <div class="form-group @if($errors->has('sender-name')) has-error @endif">
                                    <label for="sender-name">Sender Name (eg: SmileApp)</label>
                                    <input type="text" name="sender-name" value="{{ setting('email.sender-name') }}" class="form-control" id="password">
                                </div>

                                <button class="btn btn-normal">Save</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h2>Support Email</h2>
                            <p class="m-b-lg">
                                The email where the messages sent by users via contact page will come.
                            </p>
                            <form class="m-b-md" role="form" method="post" action="{{ route('admin.settings.email.support') }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="supportEmail">Email</label>
                                    <input type="email" name="support" id="supportEmail" class="form-control" value="{{ setting('email.support') }}">
                                </div>
                                <button type="submit" class="btn btn-normal">Save</button>
                            </form>
                        </div>

                    </div> <!-- end of row -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop