<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\RegisterForm;
use Livewire\Component;

class Register extends Component
{
    public RegisterForm $form;

    public function register()
    {
        $this->form->register();
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
} 