<?php

namespace App\Jobs;

use App\Mail\SendUserPhotos;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ImageProcessor implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $email,
        private string $photo,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = storage_path('app/photos/' . $this->photo);
        Mail::to($this->email)->send(
            (new SendUserPhotos())
                ->attach($filePath)
        );
    }
}
