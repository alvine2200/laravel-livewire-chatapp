<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateChat extends Component
{
    public $users;
    public $message = "Hello how are you?";

    public function checkConversation($receiverId)
    {
        $checkConversation = Conversation::where('receiver_id', Auth::user()->id)
            ->where('sender_id', $receiverId)
            ->orWhere('receiver_id', $receiverId)
            ->where('sender_id', Auth::user()->id)->get();
        if (count($checkConversation) == 0) {
            // dd('No conversation');
            $createdConversation = Conversation::create([
                'receiver_id' => $receiverId,
                'sender_id' => Auth::user()->id,
            ]);
            $createdMessage = Message::create([
                'conversation_id' => $createdConversation->id,
                'receiver_id' => $receiverId,
                'sender_id' => Auth::user()->id,
                'body' => $this->message,
            ]);

            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();
            dd($createdConversation);
            dd('saved to database');
        } else if (count($checkConversation) >= 1) {
            dd('Conversation exists');
        }
    }
    public function render()
    {
        $this->users = User::where('id', '!=', Auth::user()->id)->get();
        return view('livewire.chat.create-chat');
    }
}
