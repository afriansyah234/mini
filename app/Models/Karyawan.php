<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_karyawan',
        'email',
        'departemen_id',
    ];

    protected $table = 'karyawans';
    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'atas_nama');
    }
    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

}
