<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalStatus extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function attendes()
    {
        return $this->hasMany(Attende::class);
    }

    public function attendeCodes()
    {
        return $this->hasMany(AttendeCode::class);
    }
}
