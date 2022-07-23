<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    function answers(): HasOne
    {
        return $this->hasOne(Answer::class);
    }

    public static function getTenRandQuesWithAns()
    {
        return Question::inRandomOrder()
            ->limit(10)
            ->with('answers')
            ->get();
    }
}
