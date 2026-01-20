<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Symfony\Component\Routing\Route;

class Navbar extends Component
{
    public bool $isAuthenticated;
    public $user;

    public function __construct()
    {
        $this->isAuthenticated = Auth::check();
        $this->user = Auth::user();
    }

    public function homeRoute(): string
    {
        // Return different route based on auth status
        return $this->isAuthenticated ? route('dashboard') : route('home');
    }

    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
