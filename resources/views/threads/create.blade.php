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
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div class="form-group">
                                    <textarea name="body" id="body"  rows="8" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary">Publish</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection