<?php

namespace App\Jobs;

use App\Enums\SystemQueueNameEnum;
use App\Trait\ImageProcessingTrait;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImageProcessorJob implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;
    use ImageProcessingTrait;

    private string $storagePrefixPath = 'app/private/';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $email,
        private readonly string $imgName,
        private readonly string $srcPath,
        private readonly string $dstPath,
        private readonly array  $scaleSizes,
    )
    {
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(): void
    {
        $processedImgs = [];
        $jobs = [];
        foreach ($this->scaleSizes as $scaleSize) {
            $jobs[] = new ImageResizeJob(
                $this->imgName,
                $scaleSize,
                'jpeg',
                $this->srcPath,
                $this->dstPath,
            );
            $processedImgs[] = $this->generateNewImageName($this->imgName, $scaleSize);
        }
        $email = $this->email;

        $processedImgsWithPath = array_map(fn($img) => $this->getFileStoragePath($img, $this->storagePrefixPath . $this->dstPath), $processedImgs);
        Bus::batch([
            ...$jobs,
        ])->then(function (Batch $batch) use (&$processedImgs, &$email, &$processedImgsWithPath) {
            SendImagesInEmailJob::dispatch(
                $email,
                $processedImgsWithPath
            )->onQueue(SystemQueueNameEnum::SEND_EMAILS->value);
        })->catch(function (Batch $batch, Throwable $throwable) use ($processedImgs) {
            // do something with exception throwable $e
        })->onQueue(SystemQueueNameEnum::IMAGE_RESIZE->value)->dispatch();
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::info("Job Failed To Process & Send Email. Error:" . $exception->getMessage());
    }
}
