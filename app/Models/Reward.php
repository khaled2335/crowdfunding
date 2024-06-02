<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'reward_name',
        'reward_description',
        'shipping',
        'distination',
        'project_quantity',
        'distination_cost',
        'estimate_delivery',
        'project_quantity',
        ];
}
