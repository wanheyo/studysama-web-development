<?php

namespace App\Models;

use App\Models\UserCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_course_id',
        'name',
        'version_major',
        'version_minor',
        'desc',
        'status',
    ];

    public function userCourse()
    {
        return $this->belongsTo(UserCourse::class);
    }
}
