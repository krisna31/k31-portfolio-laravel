<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attende extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attende_code_id',
        'attende_status_id',
        'attende_time',
        'address',
        'latitude',
        'longitude',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendeCode()
    {
        return $this->belongsTo(AttendeCode::class);
    }

    public function attendeStatus()
    {
        return $this->belongsTo(AttendeStatus::class);
    }
}
