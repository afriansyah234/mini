<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        "project_id",
        "judul_tugas",
        "deskripsi",
        "prioritas",
        "status_tugas_id",
        'deadline_id',
        'karyawan_id',
        'kategori_tugas_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status_tugas::class, 'status_tugas_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function deadline()
    {
        return $this->belongsTo(Deadline::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kategoriTugas()
    {
        return $this->belongsTo(KategoriTugas::class);
    }

}
