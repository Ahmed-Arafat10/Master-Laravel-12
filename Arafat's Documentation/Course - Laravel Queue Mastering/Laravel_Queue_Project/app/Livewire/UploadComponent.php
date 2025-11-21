<?php

namespace App\Livewire;

use App\Jobs\ImageProcessor;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UploadComponent extends Component {
    use WithFileUploads;

    #[Validate('required|email')]
    public $email;

    /**
     * @var TemporaryUploadedFile|null $photo
     */
    #[Validate('required|image|max:5024')]
    public $photo;

    public function save() {
        $this->validate();
        $fileName = $this->photo->getClientOriginalName();
        $this->photo->storeAs(path: 'photos', name: $fileName);

        ImageProcessor::dispatch($this->email, $fileName);


    }

    public function render() {
        return view('livewire.upload-component');
    }
}
