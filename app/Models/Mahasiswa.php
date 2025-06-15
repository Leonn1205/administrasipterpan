<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $timestamps = false;

    protected $fillable = ['nim', 'nama_mhs', 'status_mengulang', 'dosen_sebelum', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kelompokSebagaiNim1()
    {
        return $this->hasOne(Kelompok::class, 'nim1', 'nim');
    }

    public function kelompokSebagaiNim2()
    {
        return $this->hasOne(Kelompok::class, 'nim2', 'nim');
    }

    public function getKelompokAttribute()
    {
        return Kelompok::where(function ($query) {
            $query->whereRaw('TRIM(nim1) = ?', [trim($this->nim)])
                ->orWhereRaw('TRIM(nim2) = ?', [trim($this->nim)]);
        })->first();
    }
}
