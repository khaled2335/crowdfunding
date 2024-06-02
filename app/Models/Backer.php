<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backer extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'pledge_amount',
         
        ];
        
public function projects_backer()
    {
       return $this->belongsTo('App\Models\Project','project_id');
    }   
public function user_backer()
    {
       return $this->belongsTo('App\Models\User','user_id');
    }   
    
}
