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
        'departemen',
    ];

    protected $table = 'karyawans';
    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'atas_nama');
    }

}
