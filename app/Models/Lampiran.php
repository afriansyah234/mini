<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    use HasFactory;

    protected $fillable = [
        "laporan_id",
        "nama_file",
        "path",
    ];

    protected $table = "lampirans";

    // app/Models/FileLampiran.php
    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
