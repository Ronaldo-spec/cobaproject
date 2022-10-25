<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    // protected $connection = 'mysql3';
    protected $table="payment";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
        'tipeservice',
        'layanan'
    ];
}
