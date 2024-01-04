<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsentPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approval_status_id',
        'description',
        'start_date',
        'end_date',
        'reason',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvalStatus()
    {
        return $this->belongsTo(ApprovalStatus::class);
    }
}
