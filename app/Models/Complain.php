<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    public $table = 'complaints';
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'complaint_title',
        'description',
        'is_solved',
        ];
        public function users_complaint()
    {
       return $this->belongsTo('App\Models\User','user_id');
    }
    
    public function project_complaint()
    {
      return $this->belongsTo('App\Models\Project' ,'project_id');
    }
}
