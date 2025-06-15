<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasKelompok extends Model
{
    use HasFactory;

    protected $table = 'tugas_kelompok';
    public $timestamps = false;

    protected $fillable = [
        'id_tugas',
        'id_klp',
        'file_tugas_mhs',
        'nilai',
        'bobot',
        'capaian_maksimal',
        'nilai_huruf',
        'nim_pengumpul'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'id_klp', 'id_klp');
    }
}
