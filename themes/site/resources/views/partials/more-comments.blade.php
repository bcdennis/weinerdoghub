@foreach ($comments as $comment)
    @include('site::partials.comment', ['reply' => ''])
@endforeach