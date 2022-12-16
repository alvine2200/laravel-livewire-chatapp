<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class Chatbox extends Component
{
    public $height;
    public $receiver;
    public $messages;
    public $messages_count;
    public $selectedConversation;
    public $paginator_var = 10;

    //protected $listeners = ['loadConversation', 'pushMessage', 'loadmore', 'updateHeight'];

    public function getListeners()
    {
        $auth_id = Auth::user()->id;
        return [
            "echo-private:chat.{$auth_id},MessageSent" => "broadcastedMessageReceived",
            'loadConversation', 'pushMessage', 'loadmore', 'updateHeight'
        ];
    }

    public function broadcastedMessageReceived($event)
    {
        $broadcastedMessage=Message::find($event['message']);

        if($this->selectedConversation)
        {
            if((int) $this->selectedConversation->id === (int) $event['conversation_id'])
            {
                // mark message as read
                $broadcastedMessage->read=1;
                $broadcastedMessage->save();

                //pass message to push function to save it
                $this->pushMessage($broadcastedMessage->id);
            }
        }
    }
    public function updateHeight($height)
    {
        $this->height = $height;
    }
    public function loadmore()
    {
        $this->paginator_var = $this->paginator_var + 10;
        $this->messages = Message::Where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginator_var)
            ->take($this->paginator_var)->get();

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
    }

    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');
    }

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
