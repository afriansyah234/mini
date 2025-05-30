<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_status'
    ];

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'status_tugas_id');
    }


}
