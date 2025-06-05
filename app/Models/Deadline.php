<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    use HasFactory;

    protected $fillable = [
        "tanggal",
    ];

    protected $table = "deadlines";

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function tugas()
    {
        return $this->hasOne(Tugas::class);
    }
}
