<?php

namespace App\Jobs;

use App\Trait\ImageProcessingTrait;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class ImageResizeJob implements ShouldQueue
{
    use Queueable;
    use Batchable;
    use ImageProcessingTrait;

    private ImageManager $imageManager;
    private string $storagePrefixPath = 'app/private/';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $imgName,
        private readonly int    $height,
        private readonly string $format,
        private readonly string $srcPath,
        private readonly string $dstPath,
    )
    {
        $this->imageManager = new ImageManager(
            driver: new Driver()
        );
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newFileName = $this->changePicScale(
            $this->imgName,
            $this->height,
            $this->format,
            $this->srcPath,
            $this->dstPath,
            $this->storagePrefixPath
        );
        Log::info("Done Scaling {$this->imgName} (Saved in {$this->srcPath}) Into {$this->height}x{$this->height}, New File Name: $newFileName, Saved In {$this->dstPath}");
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::info("Job Failed To Resize Image {$this->imgName} to Scale {$this->height}x{$this->height}, Error:" . $exception->getMessage());
    }
}
