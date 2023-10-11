<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function contactMeLinks()
    {
        return $this->hasMany(ContactMeLink::class, 'portfolio_id');
    }

    public function skillSets()
    {
        return $this->hasMany(SkillSet::class, 'portfolio_id');
    }
}
