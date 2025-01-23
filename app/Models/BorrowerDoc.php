<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowerDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'borrower_id',
    ];

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(TaskBorrower::class);
    }
}
