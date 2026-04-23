<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajian extends Model
{
    protected $table = 'pengajian';

    protected $guarded = ['id'] ;

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
