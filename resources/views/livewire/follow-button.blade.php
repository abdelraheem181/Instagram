<div>
    <button class="bg-blue-500 rounded-lg shadow px-2 py-2 text-white" wire:model="follow-button"
    wire:click="ToggleFollowing({{ $profile_id }})">
    {{ __($following) }}</button>
</div>
