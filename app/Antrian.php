<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';
    protected $fillable = ['kode_antrian', 'pasien_id', 'dokter_id', 'jam', 'tgl_antrian', 'poli', 'status', 'ket'];

    public function pasien()
    {
    	return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
    	return $this->belongsTo(Dokter::class);
    }
}
