<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $fillable = [
        'id',
        'user_id',
        'tanggal_feedback',
        'feedback',

    ];
    // buatrelasi dengan model user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
