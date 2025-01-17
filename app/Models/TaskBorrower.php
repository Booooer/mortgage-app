<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskBorrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'employment_type',
        'bank_salary',
        'marital_status',
        'have_children',
        'contact_id',
        'phone_id',
    ];

    public function b24Contact(): BelongsTo
    {
        return $this->belongsTo(B24Contact::class);
    }

    public function phone(): BelongsTo
    {
        return $this->belongsTo(Phone::class);
    }

    public function borrowerDocs(): HasMany
    {
        return $this->hasMany(BorrowerDoc::class, 'id');
    }
}
