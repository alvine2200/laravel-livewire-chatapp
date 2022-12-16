<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class SendMessage extends Component
{
    public $body;
    public $selectedConversation;
    public $receiverInstance;
    public $createdMessage;
    protected $listeners = ['updateSendMessage', 'dispatchMessageSent'];

    public function sendMessage()
    {
        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'receiver_id' => $this->receiverInstance->id,
            'sender_id' => Auth::user()->id,
            'body' => $this->body,
        ]);

        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;

        $this->selectedConversation->save();

        $this->emitTo('chat.chatbox', 'pushMessage', $this->createdMessage->id);
        $this->emitTo('chat.chat-list', 'refresh');
        $this->reset('body');
        $this->emitSelf('dispatchMessageSent');
    }

    public function dispatchMessageSent()
    {
        broadcast(new MessageSent(Auth::user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
    }
    public function updateSendMessage(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
    }
    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
