<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trello extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_id',
        'card_id',
        'card_name',
        'card_status',
    ];

    public function telegram()
    {
        return $this->belongsTo(Telegram::class);
    }
}
