<div  >
    <div class="main-chat-list" id="ChatList">
        @foreach($recentConversations as $recent_conversation)
        <div class="media new" wire:click="chatUserSelected({{$recent_conversation}},{{$recent_conversation->receiver->id}})">
            <div class="main-img-user online">
                <img alt="" src="{{asset('assets/img/faces/5.jpg')}}"> <span>2</span>
            </div>
            <div class="media-body">
                <div class="media-contact-name">
                    @if($recent_conversation->sender_id == auth()->user()->id)
                        <span>{{$name  = $recent_conversation->receiver->name }}</span>
                        <span>{{$recent_conversation->messages->last()->created_at->shortAbsoluteDiffForHumans()}} h</span>
                    @elseif($recent_conversation->receiver_id == auth()->user()->id)
                        <span>{{$name  = $recent_conversation->sender->name }}</span>
                        <span>{{$recent_conversation->messages->last()->created_at->shortAbsoluteDiffForHumans()}} h</span>
                    @else
                    @endif
                </div>
                <p>{{$recent_conversation->messages->last()->body}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
