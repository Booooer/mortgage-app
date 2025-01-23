<?php

namespace App\Models;

use App\Traits\HasAppTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortgageType extends Model
{
    use HasFactory;
    use HasAppTrait;

    protected $fillable = ['title', 'app_id'];

    protected $hidden = ['id', 'app_id'];
}
