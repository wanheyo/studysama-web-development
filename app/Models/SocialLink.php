<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SocialLink extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $table = 'social_links';
    
    public $incrementing = true;

    protected $fillable = [
        'name',
        'desc',
        'link',
        'user_id',
        'status',
    ];

    /**
     * Get the user that owns the social link.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
