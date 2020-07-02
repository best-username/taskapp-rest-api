<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    
    const MOBILE_IMAGE_SIZE = 300;
    const DESKTOP_IMAGE_SIZE = 1000;
    
    const STATUS_ARRAY = ['backlog' => 1, 'development' => 2, 'done' => 3, 'review' => 4];
    
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
    
    /**
     * Mutators
     */
    
    public function setStatusAttribute($value)
    {
        if(array_key_exists($value, self::STATUS_ARRAY)) {
            $this->attributes['status'] = self::STATUS_ARRAY[$value];
        }
    }
    
    /**
     * Accessors
     */
    
    public function getStatusAttribute($value)
    {
        return array_search($value, self::STATUS_ARRAY);
    }
    
}
