<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Checklist;

class ChecklistTodo extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function checkList(){
        return $this->belongsTo(Checklist::class);
    }
}
