@extends('admin::app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="container">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Categories</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    @if (isset($cat))
                        @include('admin::categories.partials.edit')
                    @else
                        @include('admin::categories.partials.add')
                    @endif
                    <div class="categories col-md-6 border-left">
                        <div class="cat-head m-b-lg">
                            <h2>Categories</h2>
                            <p class="small">
                                <i class="fa fa-hand-o-up text-danger"></i>
                                Drag categories up and down to sort.
                                (Note: In this order they will appear on the actual site.)
                            </p>
                        </div>

                        <ul class="sortable-list connectList agile-list categories-list" data-url="{{ route('admin.categories.order') }}">

                            @foreach ($categories as $category)
                            <li class="clearfix @if ($category->active) success-element @else warning-element @endif" data-id="{{ $category->id }}">
                                <div class="category-description">
                                    <h4>{{ $category->title }}</h4>
                                    <img src="{{ categoryIcon($category->icon) }}" class="category-icon" alt="Category icon">
                                    <p>{{ $category->description }}</p>
                                </div>
                                <div class="category-actions">
                                    <form action="#" class="on-off-toggle">
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" data-url="{{ route('admin.categories.status', $category->id) }}" name="active" class="onoffswitch-checkbox" @if (!$category->active) checked @endif id="statusCat{{$category->id}}">
                                                <label class="onoffswitch-label" for="statusCat{{$category->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                    <form>
                                    <a type="button" href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-white">
                                        <span class="fa fa-pencil"></span>
                                        <span class="btn-text">Edit</span>
                                    </a>
                                    </form>
                                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="post">
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <button type="submit" class="btn btn-sm btn-white">
                                            <span class="fa fa-trash-o"></span>
                                            <span class="btn-text">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div> <!-- end of categories -->
                </div>
            </div> <!-- end of ibox-content -->
        </div>
    </div> <!-- end of container -->
</div> <!-- end of wrapper wrapper-content -->
@stop