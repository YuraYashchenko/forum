<div class="card mt-3 mb-3">
    <div class="card-header">
        <a href="#">{{ $reply->user->name }}</a> said  {{ $reply->user->created_at->diffForHumans()  }} ...
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>