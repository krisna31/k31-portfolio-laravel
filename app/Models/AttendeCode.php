<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeCode extends Model
{
    use HasFactory;

    public $keyType = 'string';
    public $incrementing = false;

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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = str()->uuid();
        });
    }
}
