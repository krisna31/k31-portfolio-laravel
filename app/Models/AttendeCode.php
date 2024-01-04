<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'attende_type_id',
        'start_date',
        'end_date',
    ];

    public function attendes()
    {
        return $this->hasMany(Attende::class);
    }

    public function attendeType()
    {
        return $this->belongsTo(AttendeType::class);
    }
}
