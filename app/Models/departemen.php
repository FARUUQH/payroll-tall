<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';
    //mengizinkan mass- assignment
    protected $fillable = [
        'kode',
        'nama',
    ];
    /**
     * relasi one-to-many departemen bisa punya banyak Jabatan
     */

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'departemen_id');
    }
}
