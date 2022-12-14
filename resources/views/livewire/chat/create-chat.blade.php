<div>
    <ul class="list-group w-75 mx-auto mt-3 container-fluid">
        @foreach ($users as $user)
            <li class="list_group_item list-group_item_action" wire:click="checkConversation({{ $user->id }})" >{{ $user->name }}</li>
        @endforeach
    </ul>
</div>
