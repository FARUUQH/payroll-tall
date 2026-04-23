<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = ['id']  ;

    /**
     * relasi many to one karyawan punya 1 jabatan
     */

    public function departemen()
  {
    return $this->belongsTo(Departemen::class, 'departemen_id');
  }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function pengajian()
    {
        return $this->hasMany(Pengajian::class);
    }
}