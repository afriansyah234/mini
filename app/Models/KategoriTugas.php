<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTugas extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'nama_kategori'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

}
