<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Form;

class LoginForm extends Form
{
    #[Rule('required|email')]
    public string $email = '';
    
    #[Rule('required|min:8')]
    public string $password = '';

    public function login()
    {
        if (Auth::attempt($this->validate())) {
            session()->regenerate();
            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'form.email' => 'The provided credentials do not match our records.',
        ]);
    }
}
