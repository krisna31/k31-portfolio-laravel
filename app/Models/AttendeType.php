<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function attendeCodes()
    {
        return $this->hasMany(AttendeCode::class);
    }
}
