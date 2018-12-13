<div class="add-category edit-mode col-md-6">
    <div class="cat-head m-b-lg">
        <h2>Edit '{{ $cat->title }}' category</h2>
        <p class="small">
            <i class="fa fa-folder-open-o text-danger"></i>
            Keep your content organized :)
        </p>
    </div>
    <form action="{{ route('admin.categories.edit', $cat->id) }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group @if ($errors->has('icon')) has-error @endif">
            <label for="catIcon">Category Icon</label>
            <span>(Used for mobile.)</span>
            <input type="file" name="icon" id="catIcon" class="form-control">
            @if ($errors->has('icon'))
                <span class="help-block">{{ $errors->first('icon') }}</span>
            @endif
        </div>
        <div class="form-group @if ($errors->has('template')) has-error @endif">
            <label for="template">Template</label>
            <select class="form-control" name="template" id="template">
                <option @if ($cat->template == null) selected @endif value="null">None</option>
                @foreach (config('smile.templates') as $template)
                    <option @if ($cat->template == strtolower($template)) selected @endif  value="{{ strtolower($template) }}">{{ $template }}</option>
                @endforeach
            </select>
            @if ($errors->has('template'))
                <span class="help-block">{{ $errors->first('template') }}</span>
            @endif
        </div>
        <div class="form-group @if ($errors->has('title')) has-error @endif">
            <label for="catName">Category Name</label>
            <input type="text" name="title" id="catName" value="{{ $cat->title }}" class="form-control">
            @if ($errors->has('title'))
                <span class="help-block">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group @if ($errors->has('description')) has-error @endif">
            <label for="catDescription">Category Description</label>
            <span>(optional)</span>
            <textarea name="description" id="catDescription" class="form-control">{{ $cat->description }}</textarea>
            @if ($errors->has('description'))
                <span class="help-block">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-danger pull-right">Save</button>
    </form>
</div> <!-- end of add-category -->