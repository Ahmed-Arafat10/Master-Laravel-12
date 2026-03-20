<?php

namespace App\Livewire;

use App\Enums\SystemQueueNameEnum;
use App\Jobs\ImageProcessorAllJob;
use App\Jobs\ImageProcessorJob;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UploadComponent extends Component
{
    use WithFileUploads;

    #[Validate('required|email')]
    public $email;

    /**
     * @var TemporaryUploadedFile|null $photo
     */
    #[Validate('required|image|max:5024')]
    public $photo;

    public function save()
    {
        $this->validate();
        $srcDir = 'pics';
        $dstDir = 'picsGenerated';
        $imgName = $this->photo->getClientOriginalName();
        $this->photo->storeAs(path: $srcDir, name: $imgName);
        ImageProcessorJob::dispatch(
            $this->email,
            $imgName,
            $srcDir,
            $dstDir,
            [500, 600, 700]
        )->onQueue(SystemQueueNameEnum::IMAGE_PROCESSOR->value)->onConnection('redis');
        return back()->with([
            'success' => 'Image uploaded successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.upload-component');
    }
}
