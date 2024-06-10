<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOwner()
    {
        return $this->user_id === auth()->id();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_note');
    }
}
