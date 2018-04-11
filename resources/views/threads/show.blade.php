@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted:
                    {{$thread->title}}
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
        @foreach ($thread->replies as $reply)
            @include('threads.reply')
        @endforeach
        </div>
    </div>

    @if (auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ $thread->path() . '/replies' }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" rows="5" class="form-control" placeholder="Got something to say?"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Reply</button>
                </div>
            </form>
        </div>
    </div>
    @else
        <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
    @endif
</div>
@endsection
