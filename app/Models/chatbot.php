<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatbot extends Model
{
    use HasFactory;
    public $table = 'chatbot';
    protected $fillable=[
            'user_id',
            'question',
            'answer',
    ];
}
