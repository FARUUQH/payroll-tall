<?php

namespace App\Livewire\Master;

use App\Models\Departemen;
use App\Models\Jabatan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Manajemen Jabatan')]
class JabatanIndex extends Component
{
    use WithPagination;

    //properties
    public $jabatan_id, $departemen_id, $nama, $gaji_pokok;

    //properties ui
    public $isOpen = false;
    public $search = '';

    public function render()
    {
        //query untuk menampilkan data jabatan dengan relasi departemen dan pencarian
        $jabatans = Jabatan::with('departemen')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('departemen', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

            //mengambil nama departemen untuk dropdown
            $departemens = Departemen::orderBy('nama', 'asc')->get();

        return view('livewire.master.jabatan-index', compact('jabatans', 'departemens'));
    }

     //membuka modal

    public function openModal()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }
    ///menutup modal
    public function closeModal()
    {
        $this->isOpen = false;
    }
    //reset form
    public function resetInputFields()
    {
        $this->jabatan_id = null;
        $this->departemen_id = '';
        $this->nama = '';
        $this->gaji_pokok = '';
    }
        //membuka modal create 
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    
    //reset pagination ketika melakukan pencarian
    public function updatingSearch()
    {
        $this->resetPage ();
    }

    public function store()
    {
        $this->validate([
            'departemen_id' => 'required|exists:departemens,id',
            'nama' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

            Jabatan::updateOrCreate(['id' => $this->jabatan_id], [
               [ 'id' => $this->jabatan_id,],
               [
                'departemen_id' => $this->departemen_id,
                'nama' => $this->nama,
                'gaji_pokok' => $this->gaji_pokok
               ]
            ]);

            session()->flash('message', $this->jabatan_id ? 'Data Jabatan berhasil diperbarui.' : 'Data Jabatan berhasil dibuat.');
            $this->closeModal();
            $this->resetInputFields();
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $this->jabatan_id = $id;
        $this->departemen_id = $jabatan->departemen_id;
        $this->nama = $jabatan->nama;
        $this->gaji_pokok = $jabatan->gaji_pokok;

        $this->openModal();
    }

    public function delete($id)
    {
       try{
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->delete();
            session()->flash('message', 'Data Jabatan berhasil dihapus.');
        } catch (\illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                session()->flash('error', 'Data Jabatan tidak dapat dihapus karena masih digunakan dalam data karyawan.');
            } else {
                session()->flash('error', 'Terjadi kesalahan saat menghapus data Jabatan: ' . $e->getMessage());
            }
        }
    }
}
