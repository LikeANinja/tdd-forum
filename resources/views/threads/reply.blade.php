<reply inline-template :reply="{{$reply}}" v-cloak>

    <div id="reply-{{ $reply->id }}" class="card">
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="cancel">Cancel</button>
            </div>
            <div v-else v-text="body">
            </div>
        </div>
        @can('update', $reply)
        <div class="card-footer level">
            <button class="btn btn-default btn-sm m-r-1" @click="editing = true">Edit</button>
        	<form action="/replies/{{$reply->id}}" method="POST">
        		@csrf
        		{{ method_field('DELETE') }}
        		<button class="btn btn-danger btn-sm">Delete</button>
        	</form>
        </div>
        @endcan
    </div>

</reply>