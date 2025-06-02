<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_project'
    ];

    protected $table = 'status_projects';
}
