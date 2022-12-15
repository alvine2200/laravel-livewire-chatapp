<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;

class Chatbox extends Component
{
    public $receiver;
    public $messages;
    public $messages_count;
    public $selectedConversation;
    public $paginator_var = 10;

    protected $listeners = ['loadConversation'];

    public function loadConversation(Conversation $conversation, User $receiver)
    {
        // dd($conversation, $receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        $this->messages = Message::Where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginator_var)
            ->take($this->paginator_var)->get();
        
        $this->dispatchBrowserEvent('chatSelected');
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
