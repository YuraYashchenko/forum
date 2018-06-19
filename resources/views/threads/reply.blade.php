<div class="card mt-3 mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <p>
                    <a href="#">{{ $reply->user->name }}</a> said  {{ $reply->user->created_at->diffForHumans()  }} ...
                </p>
            </div>
            <form action="{{ route('favourites.reply', $reply->id) }}" method="POST">
                @csrf
                <button class="btn btn-default" {{ $reply->isFavourite() ? 'disabled' : '' }}>{{ $reply->favourites_count }} {{ str_plural('Like', $reply->favourites_count) }}</button>
            </form>
        </div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>