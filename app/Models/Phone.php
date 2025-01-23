<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'contact_id'];

    protected $hidden = ['id', 'contact_id'];

    public function b24contact(): BelongsTo
    {
        return $this->belongsTo(B24Contact::class, 'contact_id', 'id');
    }
}
