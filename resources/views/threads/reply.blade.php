<reply inline-template :reply="{{$reply}}" v-cloak>

    <div id="reply-{{ $reply->id }}" class="card">
        <div class="card-header">
        	<div class="level">
        		<div class="flex">
    		        <a href="{{route('userProfile', $reply->owner)}}">{{ $reply->owner->name }}</a> said
    		        {{ $reply->created_at->diffForHumans() }}
    			</div>
    	        <div>
                    @if(Auth::check())
                    <favorite :reply="{{$reply}}"></favorite>
                    @endif
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
            <button class="btn btn-danger btn-sm m-r-1" @click="destroy">Delete</button>
        </div>
        @endcan
    </div>

</reply>