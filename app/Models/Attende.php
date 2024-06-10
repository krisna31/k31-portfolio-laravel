<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attende extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'user_id',
        'attende_code_id',
        'approval_status_id',
        'attende_status_id',
        'attende_time',
        'address',
        'photo',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'photo' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendeCode()
    {
        return $this->belongsTo(AttendeCode::class);
    }

    public function approvalStatus()
    {
        return $this->belongsTo(ApprovalStatus::class);
    }

    public function attendeStatus()
    {
        return $this->belongsTo(AttendeStatus::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }
}
