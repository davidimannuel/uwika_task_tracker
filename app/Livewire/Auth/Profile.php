<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\ProfileForm;
use Livewire\Component;

class Profile extends Component
{
    public ProfileForm $form;

    public function mount()
    {
        $this->form->mount();
    }

    public function updateProfile()
    {
        $this->form->updateProfile();
    }

    public function updatePassword()
    {
        $this->form->updatePassword();
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
} 