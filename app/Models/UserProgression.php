<?php

namespace App\Models;

use App\Models\Resource;
use App\Models\UserCourse;
use Illuminate\Database\Eloquent\Model;

class UserProgression extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_course_id',
        'resource_id',
        'desc',
        'status',
    ];

    public function userCourse()
    {
        return $this->belongsTo(UserCourse::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
