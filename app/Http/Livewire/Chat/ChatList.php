<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $auth_id;
    public $name;
    public $conversations;
    public $receiverInstance;
    public $selectedConversation;

    protected $listeners = ['chatUserSelected'];

    public function chatUserSelected(Conversation $conversation, $receiverId)
    {
        // dd($conversation, $receiverId);
        $this->selectedConversation = $conversation;
        $receiverInstance = User::find($receiverId);

        $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiverInstance);
    }

    public function getChatUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = Auth::user()->id;
        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
        } else {
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }

        if (isset($request)) {
            return $this->receiverInstance->$request;
        }
    }

    public function mount()
    {
        $this->auth_id = Auth::user()->id;
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)
            ->orderby('last_time_message', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
