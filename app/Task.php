<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    
    const MOBILE_IMAGE_SIZE = 300;
    const DESKTOP_IMAGE_SIZE = 1000;
    
    const STATUS_ARRAY = ['backlog', 'development', 'done', 'review'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'image_desktop', 'image_mobile', 'status'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
    * Relations
    */
    
    public function boards()
    {
        return $this->belongsToMany(Board::class);
    }
    
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
}