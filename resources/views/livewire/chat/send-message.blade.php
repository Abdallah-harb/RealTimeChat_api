<div>
    <div>
        @if($select_conversation)
        <form wire:submit.prevent="sendMessage">
            <div class="main-chat-footer">
                <nav class="nav">
                    <a class="nav-link" data-bs-toggle="tooltip" href="" title="Add Photo"><i class="fas fa-camera"></i></a> <a class="nav-link" data-bs-toggle="tooltip" href="" title="Attach a File"><i class="fas fa-paperclip"></i></a> <a class="nav-link" data-bs-toggle="tooltip" href="" title="Add Emoticons"><i class="far fa-smile"></i></a> <a class="nav-link" href=""><i class="fas fa-ellipsis-v"></i></a>
                </nav>
                <input class="form-control" wire:model="body" placeholder="Type your message here.!" type="text">
                <button type="submit" style="background: none; border: none;" class="main-msg-send" href="">
                    <i class="far fa-paper-plane"></i>
                </button>
            </div>
        </form>
        @endif
    </div>
</div>
