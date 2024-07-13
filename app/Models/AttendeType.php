<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeType extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function attendeCodes()
    {
        return $this->hasMany(AttendeCode::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
            $model->created_by = auth()->user()->name;
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
                ->title('Attende Type Deleted')
                ->body('The attende type was deleted successfully.');
        });
    }
}
