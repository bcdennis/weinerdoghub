@extends('installer::app')

@section('content')
<div class="step-content">
    <div class="center">
    <h2>If everything is green you are good to go.</h2>
    <p class="m-b-lg">
        We did some tests to see if you can install Smile. <br/>
        If permission tests fails make sure that you grant (chmod) 777 permissions to the specified files/directories.
    </p>
    <table class="table">
        <tr>
            <td>PHP 5.4+</td>
            <td {!! passes($phpVersion) !!}>
                {{ $phpVersion['needed'] }}
            </td>
        </tr>
        <tr>
            <td>allow url fopen</td>
            <td {!! passes($allowUrlFopen) !!}>
                {{ $allowUrlFopen['needed'] }}
            </td>
        </tr>
        <tr>
            <td>Mcrypt Extension</td>
            <td  {!! passes($mcrypt) !!}>
                {{ $mcrypt['needed'] }}
            </td>
        </tr>
        <tr>
            <td>GD Extension</td>
            <td {!! passes($gd) !!}>{{ $gd['needed'] }}</td>
        </tr>
        <tr>
            <td>PDO Extension</td>
            <td {!! passes($pdo) !!}>{{ $pdo['needed'] }}</td>
        </tr>
        <tr>
            <td>FileInfo Extension</td>
            <td {!! passes($fileinfo) !!}>{{ $fileinfo['needed'] }}</td>
        </tr>
        <tr>
            <td>Storage directory permissions</td>
            <td {!! passes($storage) !!}>{{ $storage['needed'] }}</td>
        </tr>
        <tr>
            <td>Uploads directory permissions</td>
            <td {!! passes($uploads) !!}>{{ $uploads['needed'] }}</td>
        </tr>
        <tr>
            <td>Extensions directory permissions</td>
            <td {!! passes($extensions) !!}>{{ $extensions['needed'] }}</td>
        </tr>
        <tr>
            <td>.env file permissions</td>
            <td {!! passes($env) !!}>{{ $env['needed'] }}</td>
        </tr>
        <tr>
            <td>Smile on your face</td>
            <td class="alert-success">found</td>
        </tr>
    </table>
    </div>
</div> <!-- end of step-content -->
<div class="pull-right m-b-custom">
    @if ($next)
        <a href="{{ route('database') }}" class="btn btn-sm btn-danger">Next</a>
    @endif
</div>
@stop
