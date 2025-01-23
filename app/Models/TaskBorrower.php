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
        'employment_type_id',
        'bank_id',
        'marital_status_id',
        'have_children',
        'contact_id',
        'phone_id',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

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
