<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'laporan';
    protected $fillable = [
        'id',
        'tanggal_konfirmasi',
        'cara_bayar',
        'total_harga',

    ];
}
