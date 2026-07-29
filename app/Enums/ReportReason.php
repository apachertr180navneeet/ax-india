<?php

namespace App\Enums;

enum ReportReason: string
{
    case Spam = 'spam';
    case Harassment = 'harassment';
    case Violence = 'violence';
    case Copyright = 'copyright';
    case Other = 'other';
}
