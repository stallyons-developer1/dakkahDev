<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'courses';
    protected $guarded = ['id'];
    public function favorites(){
        return $this->hasMany(Favorites::class,'course_id');
    }
    public function subscriptions(){
        return $this->hasMany(Subscription::class,'course_id')->where('user_id',session()->get('user')['user_id']);
    }
    public function users(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
