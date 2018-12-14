@extends('admin::app')

@section('content')
<div class="wrapper wrapper-content">
<div class="container">
    <div class="ibox">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>All users (<span>{{ $users->total() }}</span>)</h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-md">
                        <div class="col-md-12">
                            <form action="{{ route('admin.users') }}" method="get">
                                <div class="input-group">
                                    <input type="text" placeholder="Search" name="q" class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-danger"> Go!</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="users-list">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="user-id">
                                        <span>{{ $user->id }}</span>
                                    </td>
                                    <td class="user-avatar">
                                        <img alt="image" class="img-circle" src="{{ $user->avatar ? media($user->avatar) : adminTheme('assets/img/default.png') }}">
                                    </td>
                                    <td class="user-name">
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td class="user-email">
                                        {{ perm('demo') ? 'secret@bitempest.com' : $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->permission }}
                                    </td>
                                    <td class="user-points">
                                        <span>{{ $user->points }}</span> <span class="text-danger">smiles</span> generated
                                    </td>
                                    <td class="user-since">
                                        <span>Created {{ $user->created_at->format('Y-m-d') }}</span>
                                    </td>
                                    <td class="user-status">
                                        {!! userStatus($user) !!}
                                    </td>
                                    <td class="users-actions">
                                        @if ($user->permission != 'admin')
                                        <form action="{{ route('admin.users.block', $user->id) }}" method="post">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <button type="submit" class="btn btn-white btn-sm">
                                                <i class="fa fa-ban"></i>
                                                @if ($user->blocked)
                                                    Unblock
                                                @else
                                                    Block
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <button type="submit" class="btn btn-white btn-sm">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav class="text-center">
                            {!! $users->appends(\Request::except(['page']))->links() !!}
                        </nav>
                    </div> <!-- end of users-list -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of col-md-12 -->
    </div> <!-- end of row -->
</div> <!-- end of container -->
@stop