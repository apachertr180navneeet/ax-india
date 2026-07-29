<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoCollection extends ResourceCollection
{
    public $collects = VideoListResource::class;
}
