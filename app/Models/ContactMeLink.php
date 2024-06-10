<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMeLink extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;
    protected $guarded = ['id'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
