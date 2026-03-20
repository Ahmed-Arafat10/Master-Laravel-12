<?php

namespace App\Livewire;

use App\Enums\SystemQueueNameEnum;
use App\Jobs\WordProcessorJob;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Symfony\Contracts\Service\Attribute\Required;

class UploadWordComponent extends Component {
    use WithFileUploads;

    /**
     * @var TemporaryUploadedFile $document
     */

    #[Validate('required|file|max:10024|mimes:doc,docx')]
    public $document;


    #[Validate('required|email')]
    public $email;

    public function save() {
        $this->validate();
        $fileName = $this->document->getClientOriginalName();
        $this->document->storeAs(path: 'documents', name: $fileName);
        WordProcessorJob::dispatch($this->email, $fileName)
        ->onConnection('database')
        ->onQueue(SystemQueueNameEnum::CONVERT_WORD_TO_PDF->value);
    }

    public function render() {
        return view('livewire.upload-word-component');
    }
}
