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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * 全ユーザーのチェックリストを全件取得する
     *
     * @param [type] $query
     * @return void
     */
    public function scopeFindAllForAllUsers($query)
    {
        $query
            ->select(
                'users.name as user_name',
                'users.user_id as user_id',
                'categories.name as category_name',
                'checklists.*'
            )
            ->join('users', 'users.user_id', 'checklists.user_id')
            ->join('categories', 'categories.id', 'checklists.category_id');
    }
}
