<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    // protected $connection = 'mysql3';
    protected $table="program";
    protected $primaryKey = 'id_program';
    public $timestamps = false;

    protected $fillable = [
        'id_program',
        'nama',
        'deskripsi',
        'image',
    ];
}
