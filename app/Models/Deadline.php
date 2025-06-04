<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    use HasFactory;

    protected $fillable = [
        "tugas_id",
        "tanggal",
    ];

    protected $table = "deadlines";

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
