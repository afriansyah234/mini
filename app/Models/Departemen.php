<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'nama_departemen',
    ];
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }
}
