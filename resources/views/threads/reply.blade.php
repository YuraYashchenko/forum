<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mt-3 mb-3">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <p>
                        <a href="{{ route('profiles.show', $reply->user->name) }}">{{ $reply->user->name }}</a> said  {{ $reply->user->created_at->diffForHumans()  }} ...
                    </p>
                </div>
                <form action="{{ route('favourites.reply', $reply->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-default" {{ $reply->isFavourite() ? 'disabled' : '' }}>{{ $reply->favourites_count }} {{ str_plural('Like', $reply->favourites_count) }}</button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing" >
                <div class="form-group">
                    <textarea class="form-control" rows="3" v-model="body"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-sm btn-default ml-3" @click="update">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </div>
            </div>

            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer">
            @can('update', $reply)
                <button class="btn btn-sm btn-default ml-3" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
            @endcan
        </div>
    </div>
</reply>