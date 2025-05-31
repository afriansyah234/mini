<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $fillable = [
        'foto_bukti',
        'project_id',
        'tugas_id',
        'atas_nama',
        'tanggal_laporan',
        'deskripsi_laporan',
        'status_laporan_id'
    ];

    protected $table = 'laporans';

    public function status_laporan() {
    $this->belongsTo(Laporan::class,'status_laporan_id');
    }
}
