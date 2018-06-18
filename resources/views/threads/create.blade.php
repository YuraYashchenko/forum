@extends('layouts.app')

@section ('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Create a Thread</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('threads.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <select name="channel_id" id="channel_id">
                                        <option value="">Choose a Channel</option>
                                        @foreach($channels as $channel)
                                            <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : '' }}>{{ $channel->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <textarea name="body" id="body"  rows="8" class="form-control">{{ old('body') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary">Publish</button>
                                </div>

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection