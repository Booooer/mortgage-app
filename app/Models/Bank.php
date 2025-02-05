<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected $hidden = ['id'];

    public function taskBorrowers(): HasMany
    {
        return $this->hasMany(TaskBorrower::class);
    }
}
