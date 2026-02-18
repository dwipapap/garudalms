<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|unique:users')]
    public string $email = '';

    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    #[Validate('required|min:8')]
    public string $password_confirmation = '';

    #[Validate('required|in:dosen,mahasiswa')]
    public string $role = 'mahasiswa';

    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        Auth::login($user);
        $this->redirect('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
