<?php

namespace App\Enums;

enum CommentStatus: string
{
    case Active = 'active';
    case Hidden = 'hidden';
    case Flagged = 'flagged';
}
