<?php

namespace App\Livewire\Karyawan;

use App\Models\Karyawan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

 #[Layout('components.layouts.karyawan')]
 #[Title('Data Karyawan')]
 class KaryawanIndex extends Component
{
    use WithPagination;

    public $search = '';

    // Properti untuk menyimpan data karyawan yang akan ditampilkan di modal
    public $isDetailModalOpen = false;
    public $karyawanDetail;

    public function updatingSearch()
    {
        $this->resetPage();
    }
      
    public function render()
    {
        $karyawans = Karyawan::with(['departemen', 'jabatan'])
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nik', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.karyawan.karyawan.index', compact('karyawans'));
    }

    public function showDetail($id)
    {
        /// Ambil data karyawan beserta relasi departemen dan jabatan
        $this->karyawanDetail = Karyawan::with(['departemen', 'jabatan'])->findOrFail($id);
        $this->isDetailModalOpen = true;
    }
   
    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->karyawanDetail = null; // Reset data karyawan detail
    }

    public function alertNotFinish($message, $type = 'success')
    {
        session()->flash('info', 'sabarin..');
    }

}