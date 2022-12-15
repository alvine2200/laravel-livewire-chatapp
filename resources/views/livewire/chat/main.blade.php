<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('chat') }}
        </h2>
    </x-slot>

    <div class="chat_container">

        <div class="chat_list_container">
            @livewire('chat.chat-list')            
        </div>

        <div class="chat_box_container">
            @livewire('chat.chatbox')
            @livewire('chat.send-message')
        </div>
    </div>

    <script>
        window.addEventListener('chatSelected',event=>{
            if(window.innerWidth < 768){
                $('.chat_list_container').hide();
                $('.chat_box_container').show();
            }
            $('chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
        });

        $(window).resize(function(){
            if(window.innerWidth > 768){
                $('.chat_list_container').show();
                $('.chat_box_container').show();
            }
        });

        $(document).on('click','.return',function(){
            $('.chat_list_container').show();
            $('.chat_box_container').hide();
        });

    </script>
</div>
