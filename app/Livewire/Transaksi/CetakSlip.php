<?php

namespace App\Livewire\Transaksi;

use livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout('components.layouts.print')]
#[Title('Cetak Selip Gaji')]

class CetakSlip extends Component
{
    public $penggajian;

    public function mount($id)
    {
        // ambil data gaji beserta relasi karyawan,departemen, dan jabatan
        $this->penggajian = Penggajian::with(['karyawan.departemen', 'karyawan.jabatan'])->findorfail($id);
    }
    public function render()
    {
        return view('livewire.transaksi.cetak-slip');
    }
}
