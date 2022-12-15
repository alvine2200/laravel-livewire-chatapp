<div>
    <div class="chatlist_header">
        <div class="title">
            <h4>Chat List</h4>
        </div>
        <div class="img_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&&name={{ Auth::user()->name }}" alt="profile">
        </div>
    </div>
    <div class="chatlist_body">
        @if (count($conversations) > 0)
            @foreach ($conversations as $conversation)
                <div wire:key='{{ $conversation->id }}' class="chatlist_item" wire:click="$emit('chatUserSelected',{{ $conversation }}, {{ $this->getChatUserInstance($conversation, $name = 'id') }})" >
                    <div class="chatlist_img_container">
                        <img src="https://ui-avatars.com/api/?name={{ $this->getChatUserInstance($conversation, $name = 'name') }}" alt="profile">
                    </div>
                    <div class="chatlist_info">
                        <div class="top_row">
                            <div class="list_username">
                                {{ $this->getChatUserInstance($conversation, $name = 'name') }}
                                <span class="date">
                                    {{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="bottom_row">
                            <div class="message_body text-truncate">
                                {{ $conversation->messages->last()->body }}
                            </div>
                            <div class="unread_count">
                                56
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            You have no conversations
        @endif
    </div>
</div>
