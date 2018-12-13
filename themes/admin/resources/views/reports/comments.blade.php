@extends('admin::app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="container">
        <div class="ibox">
            <div class="ibox-title settings-nav">
                <div class="row secondary-navigation">
                    <nav class="navbar" role="navigation">
                        <div class="navbar-header">
                            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar-settings" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse" id="navbar-settings">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="{{ route('admin.reports.posts') }}">Posts Reports ({{ $postsNum }})</a>
                                </li>
                                <li class="active">
                                    <a href="{{ route('admin.reports.comments') }}">Comments Reports ({{ $commentsNum }})</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div> <!-- end of secondary-navigation -->
            </div> <!-- end of ibox-title -->
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <div class="col-md-12">
                        <form action="{{ route('admin.reports.comments') }}" method="get">
                            <div class="input-group">
                                <input type="text" placeholder="Search" name="q" class="input-sm form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-danger"> Go!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="reports-list">
                    <div class="table-responsive reported-comments">
                        <table class="table table-hover">
                            @foreach ($reports as $report)
                            <tr>
                                <td class="post-meta">
                                    <a href="#" class="post-title">
                                        {{ $report->comment->message }}
                                    </a>

                                    <small>
                                        Added by
                                        <strong>{{ $report->comment->user->name }}</strong>
                                        <span>|</span>
                                        <span>{{ $report->comment->user->email }}</span>
                                    </small>
                                </td>
                                <td class="report-author">
                                    <span class="font-bold">{{ $report->user->name }}</span>
                                    @if ($report->other > 0)
                                    <span>and other</span>
                                    <span class="font-bold">{{ $report->other }}</span>
                                    @endif
                                    reported this comment
                                </td>
                                <td class="report-actions">
                                    <a target="_blank" href="{{ route('post', $report->comment->post->slug) }}" class="btn btn-white btn-sm">
                                        <i class="fa fa-search"></i>
                                        View Post
                                    </a>
                                    <form action="{{ route('admin.comments.delete', $report->comment->id) }}" method="post">
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <button type="submit" class="btn btn-white btn-sm">
                                            <i class="fa fa-trash-o"></i>
                                            Delete Comment
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reports.comments.close', $report->comment->id) }}" method="post">
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <button type="submit" class="btn btn-white btn-sm">
                                            <i class="fa fa-check"></i>
                                            Close Report
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div> <!-- end of table-responsive -->
                    <nav class="text-center">
                        {!! paginator($reports->appends(Input::except(['page']))) !!}
                    </nav>
                </div> <!-- end of reports-list -->
            </div> <!-- end of ibox-content -->
        </div> <!-- end of ibox -->
    </div> <!-- end of container -->
</div> <!-- end of wrapper wrapper-content -->
@stop