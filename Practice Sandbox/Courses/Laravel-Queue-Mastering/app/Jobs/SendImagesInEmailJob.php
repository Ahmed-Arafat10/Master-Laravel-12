<?php

namespace App\Jobs;

use App\Mail\SendUserPhotosMail;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendImagesInEmailJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public $uniqueFor = 3600;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $email,
        private readonly array $processedImgs
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = new SendUserPhotosMail();
        Mail::to($this->email)->send(
            $mail->attachMany($this->processedImgs)
        );
    }

    public function uniqueId(): string
    {
        return $this->email;
    }
}
