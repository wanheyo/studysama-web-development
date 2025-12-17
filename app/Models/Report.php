<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'reported_id',
        'reported_type',
        'reason',
        'action',
        'status',
        'remark',
        'admin_id',
        'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'status' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * The user who submitted the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The admin who handled the report (if any).
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function reported()
    {
        return $this->morphTo();
    }

}
