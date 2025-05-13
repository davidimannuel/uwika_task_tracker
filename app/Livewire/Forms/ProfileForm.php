<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ProfileForm extends Form
{
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('required')]
    public string $current_password = '';

    #[Rule('required|min:8|confirmed')]
    public string $new_password = '';

    public string $new_password_confirmation = '';

    public function mount()
    {
        $this->name = Auth::user()->name;
    }

    public function updateProfile()
    {
        $user = Auth::user();
        $user->name = $this->name;
        $user->save();

        session()->flash('success', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('success', 'Password updated successfully.');
    }
} 