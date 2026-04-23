<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    /**
     * relasi one-to-many jabatan hanya punya satu departemen
     */

    protected $fillable = [
        'departemen_id',
        'nama',
        'gaji_pokok'
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}
