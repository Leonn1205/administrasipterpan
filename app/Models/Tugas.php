<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    public $timestamps = false;

    protected $fillable = [
        'id_dosen',
        'judul',
        'mulai',
        'kumpul_sblm',
        'file_tugas_dosen',
    ];

    // Relasi ke dosen pembuat tugas
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id_dosen');
    }

    // Relasi many-to-many ke kelompok melalui tabel tugas_kelompok
    public function kelompok()
    {
        return $this->belongsToMany(Kelompok::class, 'tugas_kelompok', 'id_tugas', 'id_klp')
                    ->withPivot([
                        'id',
                        'file_tugas_mhs',
                        'nilai',
                        'bobot',
                        'capaian_maksimal',
                        'nilai_huruf',
                        'nim_pengumpul',
                    ]);
    }
}
