<div>


    @if ($selectedConversation)
        <div class="chatbox_header">
            <div class="return">
                <i class="bi bi-arrow-left"></i>
            </div>

            <div class="img_container">
                <img src="https://picsum.photos/id/43/207/300" alt="profile">
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
            <div class="msg_body msg_body_receiver">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, molestiae, delectus beatae, suscipit
                quaerat adipisci odio officiis ab repellat excepturi veritatis fugiat aspernatur soluta? Saepe, laborum!
                Neque odit natus sed.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem et rerum omnis in consequatur praesentium
                iusto
                sint unde. Explicabo sapiente quisquam libero ab sit sequi molestias unde odio dolorum ipsum!
                <div class="msg_body_footer">
                    <div class="date">
                        5 hrs ago
                    </div>
                    <div class="read">
                        <i class="bi bi-check"></i>
                    </div>
                </div>
            </div>
        </div>
    @else

    No conversation selected
    @endif

    {{-- <div class="chatbox_footer">
        @livewire('chat.send-message')
    </div> --}}

</div>
