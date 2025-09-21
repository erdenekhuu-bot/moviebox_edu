<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
class Trends extends Component
{
    public $title;

    public function mount(){
        $this->title = "Trends";
    }
    public function render(): View
    {
        return view('livewire.trends');
    }
}
