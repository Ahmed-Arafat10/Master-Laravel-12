<?php

namespace App\Jobs;

use App\Mail\SendUserPdfMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;


class WordProcessorJob implements ShouldQueue
{
    use Queueable;

    private string $srcDir;
    private string $dstDir;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $email,
        private readonly string $fileName
    )
    {
        $this->srcDir = storage_path('app/private/documents/');
        $this->dstDir = storage_path('app/private/documentsProcessed/');
    }

    /**
     * @throws Exception
     */
    private function old()
    {
        $fileName = $this->fileName;
        $rendererName = Settings::PDF_RENDERER_DOMPDF;
        $rendererLibraryPath = base_path('/vendor/dompdf/dompdf');
        Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

        $wordFilePath = $this->srcDir . $fileName;

        $wordDocument = IOFactory::load($wordFilePath);

        $writer = IOFactory::createWriter($wordDocument, 'PDF');

        $pdfFilePath = $this->dstDir . pathinfo($fileName, PATHINFO_FILENAME) . '.pdf';
        $writer->save($pdfFilePath);
    }

    private function sendEmail($pdfFilePath)
    {
        $sendUsersPdf = new SendUserPdfMail();
        $sendUsersPdf->attach($pdfFilePath);
        Mail::to($this->email)->send($sendUsersPdf);
    }


    private function libreoffice()
    {
        if (!is_dir($this->dstDir)) {
            mkdir($this->dstDir, 0777, true);
        }
        $wordFilePath = $this->srcDir . $this->fileName;
        $pdfFileName = pathinfo($this->fileName, PATHINFO_FILENAME) . '.pdf';
        $pdfFilePath = $this->dstDir . $pdfFileName;
        $command = sprintf(
            'libreoffice --headless --convert-to pdf --outdir %s %s',
            escapeshellarg($this->dstDir),
            escapeshellarg($wordFilePath)
        );
        exec($command, $output, $returnVar);
        if ($returnVar !== 0) {
            throw new \Exception("Failed to convert DOCX to PDF: " . implode("\n", $output));
        }
        return $pdfFilePath;
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        $this->sendEmail(
            $this->libreoffice()
        );
    }


    public function failed(\Throwable $exception): void
    {
        Log::info($exception->getMessage());
    }

    public function middleware()
    {
        return [
            new SkipIfBatchCancelled
        ];
    }
}
