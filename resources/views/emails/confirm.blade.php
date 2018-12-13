@extends('emails.email')

@section('content')
    <tr>
        <td class="content-block">
            <h3>Welcome, {{ $user->name }}</h3>
        </td>
    </tr>
    <tr>
        <td class="content-block">
            Thanks for joining us. In order to use your account you need to confirm you email address. Just click the link below!
        </td>
    </tr>
    <tr>
        <td class="content-block aligncenter">
            <a href="{{ route('confirm', ['email' => $user->email, 'token' => $user->confirmation_code]) }}" class="btn-primary">
                Confirm email address
            </a>
        </td>
    </tr>
@stop