<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginModal extends Component
{
    public $show = false;
    public $email;
    public $password;

    protected $listeners = ['openLogin' => 'open'];

    public function open()
    {
        $this->show = true;
    }

    public function login()
    {
        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            $this->show = false;
            $this->dispatch('loginSuccess');
        }
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}