<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Login')]
class Login extends Component
{
    public $email='';
    public $password='';

    public function authenticate()
    {
        //validasi input
        $credentials = $this->validate ([
            'email' => 'required|email', 
            'password' => 'required'
            ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'Email atau password salah');
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
