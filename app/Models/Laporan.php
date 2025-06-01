<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'atas_nama',
        'deskripsi_laporan',
    ];

    protected $table = 'laporans';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'atas_nama');
    }

    // app/Models/Laporan.php
    public function lampiran()
    {
        return $this->hasOne(Lampiran::class, 'laporan_id');
    }
}
