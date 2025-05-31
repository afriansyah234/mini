<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLaporan extends Model
{
    use HasFactory;

     protected $fillable = [
        'status_laporan'
    ];

     protected $table = 'status_laporan';

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'status_laporan_id');
    }
}
