<?php

namespace App\Jobs;

use App\Mail\SendUserPhotosMail;
use App\Trait\ImageProcessingTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class ImageProcessorAllJob implements ShouldQueue
{
    use Queueable;
    use ImageProcessingTrait;
    private ImageManager $imageManager;
    private string $generatedPicPath = 'app/private/picsGenerated/';
    private array $scaleSizes;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $email,
        private readonly string $photo,
    )
    {
        $this->imageManager = new ImageManager(
            driver: new Driver()
        );
        $this->scaleSizes = [
            50, 100, 200, 300, 500
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $processedImgs = [];
        foreach ($this->scaleSizes as $scaleSize) {
            $processedImgs[] = $this->changePicScale($this->photo, $scaleSize);
        }
        Mail::to($this->email)->send(
            (new SendUserPhotosMail())
                ->attachMany(array_map(fn($img) => $this->getFileStoragePath($img, $this->generatedPicPath), $processedImgs))
        );
        foreach ($processedImgs as $i => $img) {
            $s = $this->scaleSizes[$i];
            Log::info("Done Scaling {$this->photo} Into {$s}x{$s}, New File Name: $img");
        }

    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::info("Job Failed: " . $exception->getMessage());
    }
}
