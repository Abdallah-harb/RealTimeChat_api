<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class Main extends Component
{

    public function render()
    {
        return view('livewire.chat.main')->extends('Dashboard.layouts.master');
    }
}