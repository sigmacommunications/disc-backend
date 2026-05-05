<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'album_id' => $this->album_id,
            'artist_id' => $this->artist_id,
            'title' => $this->title,
            'duration' => $this->duration,
            'genre_id' => $this->genre_id,
            'audio_file' => $this->audio_file_path, // Changed key name
            'cover_image' => $this->cover_image_path,
            'description' => $this->description,
            'approved' => $this->approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'royalty_amount' => $this->royalty_amount,
            'play_count' => $this->play_count,
            'is_liked' => $this->is_liked,
            'artist' => $this->whenLoaded('artist'),
        ];
    }
}