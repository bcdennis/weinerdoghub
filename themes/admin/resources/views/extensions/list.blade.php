@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Modules (<span>{{ $extensions->count() }}</span>)</h5>
                </div>
                <div class="ibox-content">
                    <div class="modules-list">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="text-left">
                                    <th>#</th>
                                    <th class="width-1">Name</th>
                                    <th class="width-4">Description</th>
                                    <th>Author</th>
                                    <th>Version</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach ($extensions as $id => $extension)
                                    <tr>
                                        <td>{{ $id + 1 }}</td>
                                        <td>{{ $extension->manifest()->name }}</td>
                                        <td>{{ $extension->manifest()->description }}</td>
                                        <td>{{ $extension->manifest()->author }}</td>
                                        <td>{{ $extension->manifest()->version }}</td>
                                        <td>
                                            <form class="pull-left" role="form">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <div class="switch">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" data-url="{{ route('admin.extensions.status', $extension->getName()) }}" class="onoffswitch-checkbox" id="module{{ $extension->getName() }}" @if (!$extension->isActive()) checked @endif>
                                                        <label class="onoffswitch-label" for="module{{ $extension->getName() }}">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            @if ($extension->isInstalled())
                                                <form action="{{ route('admin.extensions.uninstall', $extension->getName()) }}" method="post" class="display-inline">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <button type="submit" class="btn btn-white btn-sm">
                                                        <i class="fa fa-trash-o"></i>
                                                        Uninstall
                                                    </button>
                                                </form>
                                                @if ($extension->settingsRoute)
                                                    <a href="{{ route($extension->settingsRoute) }}" class="btn btn-white btn-sm">
                                                        <i class="fa fa-cog"></i>
                                                        Settings
                                                    </a>
                                                @endif
                                            @else
                                                <form action="{{ route('admin.extensions.install', $extension->getName()) }}" method="post" class="display-inline">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <button type="submit" class="btn btn-white btn-sm">
                                                        Install
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end of table-responsive -->
                    </div> <!-- end of modules-list -->
                </div> <!-- end of ibox-content -->
            </div> <!-- end of ibox -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper wrapper-content -->
@stop