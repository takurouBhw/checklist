<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\User;

class Checklist extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


    public function getCheckList() {
        return DB::table('checklists')
        ->join('users', 'users.user_id', 'checklists.user_id')
        ->get();
    }

}
