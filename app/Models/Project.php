<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_project',
        'deskripsi',
        'deadline',
        'status_project',
        'karyawan_id'
    ];
    protected $table = 'projects';

    public function penanggungjawab()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
     public function anggota()
    {
        return $this->belongsToMany(Karyawan::class, 'anggota_project');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'project_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusProject::class, 'status_project');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    // App\Models\Project.php
    public function scopeSelesai($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('status_project', 'selesai');
        });
    }

}
