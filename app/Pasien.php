<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
	protected $table = 'pasien';
    protected $fillable = ['user_id', 'nip', 'nama', 'tempat_lahir', 'tgl_lahir', 'jk', 'agama', 'alamat', 'hp'];

    /**
     * Method One To One 
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    /**
     * Method One To Many 
     */
    public function antrian()
    {
    	return $this->hasMany(Antrian::class);
    }
    
}
