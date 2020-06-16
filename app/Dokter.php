<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $fillable = ['nama_dokter',  'jumlah_dokter', 'poli', 'ket', 'cover'];
    
    /**
     * Method One To Many 
     */
    public function antrian()
    {
    	return $this->hasMany(Antrian::class);
    }
}
