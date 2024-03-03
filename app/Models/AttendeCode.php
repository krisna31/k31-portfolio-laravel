<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeCode extends Model
{
    use HasFactory;

    protected $casts = ['id' => 'string'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        "user_id",
        "default_approval_status_id",
        'description',
        'attende_type_id',
        'start_date',
        'end_date',
        'latitude',
        'longitude',
        'radius',
        'created_at',
        'updated_at'
    ];

    public function attendes()
    {
        return $this->hasMany(Attende::class);
    }

    public function attendeType()
    {
        return $this->belongsTo(AttendeType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function defaultApprovalStatus()
    {
        return $this->belongsTo(ApprovalStatus::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = str()->uuid();
            $model->created_at = now();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }
}
