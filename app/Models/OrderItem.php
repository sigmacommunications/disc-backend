<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];
    protected $casts = [
        'printify_data' => 'array',
    ];
    public function merchItem()
    {
        return $this->belongsTo(MerchItem::class);
    }
}
