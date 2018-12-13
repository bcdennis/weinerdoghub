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
                                    <a href="{{ route('admin.posts') }}">Posts ({{ $posts->total() }})</a>
                                </li>
                                <li class="active">
                                    <a href="{{ route('admin.posts.hold') }}">On Hold Posts ({{ formatNumber($hold->total()) }})</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div> <!-- end of secondary-navigation -->
            </div> <!-- end of ibox-title -->
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <div class="col-md-12">
                        <form action="{{ route('admin.posts.hold') }}" method="get">
                            <div class="input-group">
                                <input type="text" placeholder="Search" name="q" class="input-sm form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-danger"> Go!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                    <div class="posts-list">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                @foreach ($hold as $post)
                                <tr>
                                    <td class="post-id">{{ $post->id }}</td>
                                    <td class="post-preview">
                                        <a href="#" class="image-modal" data-toggle="modal" data-target="#view-post" data-url="{{ media($post->thumbnail ?: $post->featured) }}">
                                            <img src="{{ media($post->thumbnail ?: $post->featured) }}" alt="post preview">
                                        </a>
                                    </td>
                                    <td class="post-meta">
                                        <a target="_blank" href="{{ route('post', $post->slug) }}" class="post-title">
                                            {{ $post->title }}
                                        </a>

                                        <small>
                                            Added by
                                            <strong>{{ $post->user->name }}</strong>
                                            <i class="fa fa-clock-o"></i>
                                            {{ $post->created_at->format('l h:i - d-m-y') }}
                                        </small>
                                    </td>
                                    <td class="post-categories">
                                        <span class="small font-bold">Categories</span>
                                        <div class="tag-list">
                                            @foreach ($post->categories as $category)
                                                <span class="label">{{ $category->title }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="post-actions">
                                        <form action="{{ route('admin.posts.accept', $post->id) }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-white btn-sm">
                                                <i class="fa fa-check"></i>
                                                Allow
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.posts.delete', $post->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-white btn-sm">
                                                <i class="fa fa-ban"></i>
                                                Deny
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div> <!-- end of table-responsive -->
                        <nav class="text-center">
                            {!! paginator($hold->appends(Input::except(['page']))) !!}
                        </nav>
                    </div> <!-- end of posts-list -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of container -->
        </div> <!-- end of wrapper wrapper-content -->
    </div> <!-- end of col-lg-12 -->
    <div class="modal fade" id="view-post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog text-center" role="document">
            <img src="#" alt="Post Preview">
        </div>
    </div> <!-- end of modals -->
@stop