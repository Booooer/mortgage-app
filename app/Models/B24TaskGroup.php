<?php

namespace App\Models;

use DomDev\B24LaravelApp\Models\B24Install;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class B24TaskGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'group_id',
    ];

    public function b24Install(): BelongsTo
    {
        return $this->belongsTo(B24Install::class);
    }
}
