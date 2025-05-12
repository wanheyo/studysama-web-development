<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\ResourceFile;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'lesson_id',
        'file_id', //nullable
        'name',
        'desc', //nullable
        'link', //nullable
        'category',
        'total_visit',
        'status'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function resourceFile()
    {
        return $this->belongsTo(ResourceFile::class, 'file_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
