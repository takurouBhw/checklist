<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category1 extends Model
{
    use HasFactory;
    protected $appends = ['user_id'];

    public function getUserIdAttribute()
    {
        return '123344445';
    }
}
