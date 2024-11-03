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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
            $model->created_by = auth()->user() ? auth()->user()->name : 'System';
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
                ->title('Approval Status Deleted')
                ->body('The Approval Status was deleted successfully.');
        });
    }
}
