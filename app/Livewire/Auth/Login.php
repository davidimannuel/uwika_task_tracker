<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->form->login();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
} 