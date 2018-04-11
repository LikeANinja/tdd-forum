@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new thread</div>

                <div class="card-body">

                    <form action="/threads" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" placeholder="Title" name="title">
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea name="body" id="body" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success">Publish</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
