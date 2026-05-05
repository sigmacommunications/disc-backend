<?php
// app/Http/Resources/AlbumResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'artist_id' => $this->artist_id,
            'title' => $this->title,
            'release_date' => $this->release_date,
            'cover_image' => $this->cover_image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
        ];
    }
}