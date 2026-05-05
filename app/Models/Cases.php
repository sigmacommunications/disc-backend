<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $guarded = [];
    protected $casts = [
        'responded_at' => 'datetime',
    ];
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get the user who created the case.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
