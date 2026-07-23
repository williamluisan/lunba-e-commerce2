<?php

use Livewire\Component;

use Flux\Flux;

new class extends Component
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    function createAccount() 
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        Flux::toast('Your changes have been saved.');
    }
};
?>

<div>
    <div class="mb-6">
        <flux:heading>Create an account</flux:heading>
        <flux:text class="mt-2">We're excited to have you on board.</flux:text>
    </div>
    <flux:input label="Name" wire:model="name"/>
    <flux:input class="mb-6" label="Email" wire:model="email" />
    <div class="mb-6 flex *:w-1/2 gap-4">
        <flux:input label="Password" wire:model="password" />
        <flux:input label="Confirm password" wire:model="password_confirmation" />
    </div>
    <flux:button wire:click="createAccount" variant="primary">Create account</flux:button>
</div>