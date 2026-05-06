<?php

namespace App\Livewire\Master;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Departemen;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Manajemen Departemens')]
class DepartemenIndex extends Component
{
    use WithPagination;

    //properti forme
    public $departemen_id, $kode, $name;

    public $IsOpen = false;
    public $search = '';    

    //reset pagination ketika melakukan pencarian
    public function updatingSearch()
    {
        $this->resetPage ();
    }

    public function render()
    {
        $departemens = Departemen::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('kode', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return view('livewire.master.departemen-index', compact ('departemens'));
    }

    //membuka modal

    public function openModal()
    {
        $this->resetInputFields();
        $this->IsOpen = true;
    }
    ///menutup modal
    public function closeModal()
    {
        $this->IsOpen = false;
    }
    //reset form
    public function resetInputFields()
    {
        $this->departemen_id = null;
        $this->kode = '';
        $this->name = '';
    }
    //membuka modal create 
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    
    //mencreate update data
    public function store()
    {
        $this->validate([
            'kode' => 'required|unique:departemen,kode,' . $this->departemen_id,
            'name' => 'required|string|max:255' 
        ]);

        Departemen::updateOrCreate(['id' => $this->departemen_id], [
        
            'kode' => strtoupper($this->kode),//memastikan kodee yg disimpan adalah kapital
            'name' => $this->name,
        ]);

        session()->flash('message', $this->departemen_id ? 'Data Departemen berhasil diperbarui.' : 'Data Departemen berhasil dibuat.');

        $this->resetInputFields();
        $this->closeModal();
    }
    //memebuka modal edit
    public function edit($id)
    {
        $departemen = Departemen::findOrFail($id);
        $this->departemen_id = $id;
        $this->kode = $departemen->kode;
        $this->name = $departemen->name;

        $this->openModal();
    }
    //menghapus data
    public function delete($id)
    {
        $departemen = Departemen::withCount('jabatan');
        $departemen = $departemen->findOrFail($id);

        if ($departemen->jabatan_count > 0) {
            session()->flash('error', 'Gagal menghapus Departemen. Pastikan tidak ada Jabatan yang terkait dengan Departemen ini.');
            return;
        } 
        $departemen->delete();
        session()->flash('message', 'Data Departemen berhasil dihapus.');
    }
}
