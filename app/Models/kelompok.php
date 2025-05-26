<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompok';
    protected $primaryKey = 'id_klp';
    public $timestamps = false;

    protected $fillable = [
        'id_dosen',
        'nim1',
        'nim2'
    ];

    // Relasi ke dosen pembimbing
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id_dosen');
    }

    // Relasi ke mahasiswa 1
    public function mahasiswa1()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim1', 'nim');
    }

    // Relasi ke mahasiswa 2
    public function mahasiswa2()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim2', 'nim');
    }
}
