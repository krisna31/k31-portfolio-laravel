<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeCode extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

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
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
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
            $model->created_at = now();
            $model->created_by = auth()->user()->name ?? "Salyma Dewi";
        });

        static::updating(function ($model) {
            $model->updated_at = now();
            $model->updated_by = auth()->user()->name;
        });

        static::deleting(function ($model) {
            $model->deleted_at = now();
            $model->deleted_by = auth()->user()->name;
            $model->save();
            return \Filament\Notifications\Notification::make()
                ->success()
                ->title('Attende Code Deleted')
                ->body('The attende code was deleted successfully.');
        });
    }
}
