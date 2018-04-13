@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
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



            @foreach ($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
                <form action="{{ $thread->path() . '/replies' }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" rows="5" class="form-control" placeholder="Got something to say?"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Reply</button>
                    </div>
                </form>
            @else
                <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a> and
                        currently has {{ $thread->replies_count }} {{str_plural('comment', $thread->replies_count)}}.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
