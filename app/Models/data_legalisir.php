<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_legalisir extends Model
{
    use HasFactory;

    protected $table = "data_legalisir";

    protected $fillable = [
        "nama",
        "jenis_akta",
        "no_akta",
        "alasan",
        "gambar",
        "status",
        "finished_at"
    ];

    protected $casts = [
        'finished_at' => 'datetime',
    ];
}
