<div class="card">
    <div class="card-header">
    	<div class="level">
    		<div class="flex">
		        <a href="{{route('userProfile', $reply->owner)}}">{{ $reply->owner->name }}</a> said
		        {{ $reply->created_at->diffForHumans() }}
			</div>
	        <div>

	        	<form action="/replies/{{$reply->id}}/favorites" method="POST">
	        		@csrf
	        		<button class="btn btn-default btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
	        			{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
	        		</button>
	        	</form>
	        </div>
	    </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>