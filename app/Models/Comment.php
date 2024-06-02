<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'comment_text',
         
        ];
        public function projects_comment()
    {
       return $this->belongsTo('App\Models\Project','project_id');
    }   
public function user_comment()
    {
       return $this->belongsTo('App\Models\User','user_id');
    }  
}
