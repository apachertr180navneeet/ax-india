<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaylistCollection extends ResourceCollection
{
    public $collects = PlaylistResource::class;
}
