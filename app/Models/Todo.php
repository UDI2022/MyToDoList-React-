<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;
    /**
     * $fillable():一括代入が可能なカラムを定義
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'progress',
    ];

    /**
     * TodoモデルとUserモデルの間に「多対一」の関係
     * Todo-User
     * ↓
     * todos.user_id = users.id
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
