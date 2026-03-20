<?php

namespace App\Enums;

enum SystemQueueNameEnum: string
{
    case IMAGE_PROCESSOR = 'image-processor';
    case SEND_EMAILS = 'send-emails';
    case IMAGE_RESIZE = 'image-resize';
    case CONVERT_WORD_TO_PDF = 'convert-word-to-pdf';
    // vendor/bin/sail artisan queue:listen --verbose --queue=
}
