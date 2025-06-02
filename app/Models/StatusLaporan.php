<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLaporan extends Model
{
    use HasFactory;

     protected $fillable = [
        'statuslaporan'
    ];

     protected $table = 'statuslaporan';

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'statuslaporan');
    }
}
