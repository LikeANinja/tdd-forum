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
                            <label>Channel</label>
                            <select name="channel_id" class="form-control" required>
                                <option value="">Choose One...</option>
                                @foreach (\App\Models\Channel::all() as $channel)
                                    <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : '' }}>
                                        {{$channel->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" placeholder="Title" name="title" value="{{old('title')}}" required>
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea name="body" id="body" rows="5" class="form-control" required>{{old('body')}}</textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success">Publish</button>
                        </div>
                    </form>
                    @if (count($errors))
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
