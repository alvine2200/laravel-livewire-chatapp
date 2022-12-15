<div>

    @if ($selectedConversation)
        <div class="chatbox_header">
            <div class="return">
                <i class="bi bi-arrow-left"></i>
            </div>

            <div class="img_container">
                <img src="https://ui-avatars.com/api/?name={{ $receiverInstance->name }}" alt="profile">
            </div>

            <div class="name">
                {{ $receiverInstance->name }}
            </div>

            <div class="info">
                <div class="info_item">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="info_item">
                    <i class="bi bi-image"></i>
                </div>
                <div class="info_item">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
            </div>
        </div>
        <div class="chatbox_body">
            @foreach ($messages as $message)
                <div wire:key='{{ $message->id }}'
                    class="msg_body {{ Auth::user()->id == $message->sender_id ? 'msg_body_me' : 'msg_body_receiver' }}">
                    {{ $message->body }}
                    <div class="msg_body_footer">
                        <div class="date">
                            {{ $message->created_at->format('m: i a') }}
                        </div>
                        <div class="read">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            $('.chatbox_body').on('scroll', function() {
                const top = $('.chatbox_body').scrollTop();
                if (top == 0) {
                    window.livewire.emit('loadmore');
                }
            });
        </script>
        <script>
            window.addEventListener('updatedHeight', event => {
                let old = event.detail.height;
                let newHeight = $('.chatbox_body')[0].scrollHeight;

                let height = $('.chatbox_body').scrollTop(newHeight - old);
                window.livewire.emit('updateHeight', {
                    height: height,
                });
            });
        </script>
    @else
        <div class="fs-4 text-center text-primary mt-5">
            No conversation selected
        </div>
    @endif
    <script>
        window.addEventListener('rowChatToBottom', event => {
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
        });
    </script>

    {{-- <div class="chatbox_footer">
        @livewire('chat.send-message')
    </div> --}}

</div>
