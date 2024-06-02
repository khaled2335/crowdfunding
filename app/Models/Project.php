<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'title', 
        'description' ,
        'photos',
        'second_photo',
        'videos',
        'acceptans',
        'goal_amount',
        'collected_money',
        'start_date',
        'end_date',
        'category'
        ];

    

    public function users()
    {
       return $this->belongsTo('App\Models\User','user_id');
    }
    public function backers()
    {
      return $this-> hasMany('App\Models\Backer' , 'project_id') ;
    }
    public function complaints_project()
    {
      return $this-> hasMany('App\Models\Complain' , 'project_id') ;
    }
}
