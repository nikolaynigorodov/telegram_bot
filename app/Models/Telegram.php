<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_user_id',
        'telegram_user_name',
        'trello_user_id',
        'trello_user_name',
    ];

    public function trellos()
    {
        return $this->hasMany(Trello::class);
    }
}
