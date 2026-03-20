<?php

namespace App\Http\Controllers;

use App\Mail\SendUserPdfMail;
use App\Mail\SendUserPhotosMail;
use App\Trait\ImageProcessingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class PracticeController extends Controller
{
    use ImageProcessingTrait;

    private string $srcDir;
    private string $dstDir;

    /**
     * Create a new job instance.
     */
    public function __construct(
    )
    {
        $this->srcDir = storage_path('app/private/documents/');
        $this->dstDir = storage_path('app/private/documentsProcessed/');
    }

    private function libreoffice()
    {
//        if (!is_dir($dstDir)) {
//            mkdir($dstDir, 0777, true);
//        }

        $fileName = 'My Proposal.docx';
        $wordFilePath = $this->srcDir . $fileName;
        $pdfFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.pdf';
        $pdfFilePath = $this->dstDir . $pdfFileName;

        // Build the libreoffice shell command
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

    public function __invoke()
    {
        $this->libreoffice();
    }
}
