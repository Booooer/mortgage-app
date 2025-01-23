<?php

namespace App\Models;

use App\Traits\HasAppTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class B24Contact extends Model
{
    use HasFactory;
    use HasAppTrait;

    protected $fillable = [
        'bitrix_id',
        'app_id',
        'name',
        'surname',
        'last_name',
    ];

    protected $hidden = [
        'id',
        'app_id',
    ];

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class, 'contact_id', 'id');
    }
}
