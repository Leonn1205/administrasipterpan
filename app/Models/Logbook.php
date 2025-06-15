<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    protected $table = 'logbook'; 
    protected $primaryKey = 'id_logbook';
    public $timestamps = false;
    protected $fillable = [
        'nim',
        'tanggal',
        'uraian_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'yang_terlibat',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
