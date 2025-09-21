<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadVideo extends Component
{
    use WithFileUploads;
    private $video;
    private $progress=0;
    protected $rules=[];
    public function render()
    {
        return view('livewire.upload-video');
    }
}
