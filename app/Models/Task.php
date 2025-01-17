<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'type',
        'wished_sum',
        'have_init_payment',
        'init_payment',
        'comment',
        'maternity_capital',
        'init_payment_source_id',
        'mortgage_type_id',
        'live_complex_id',
        'borrower_id',
        'author_id',
        'app_id',
    ];

    public function taskBorrower(): BelongsTo
    {
        return $this->belongsTo(TaskBorrower::class);
    }

    public function liveComplex(): BelongsTo
    {
        return $this->belongsTo(LiveComplex::class);
    }

    public function initPaymentSource(): BelongsTo
    {
        return $this->belongsTo(InitPaymentSource::class);
    }

    public function mortgageType(): BelongsTo
    {
        return $this->belongsTo(MortgageType::class);
    }
}
