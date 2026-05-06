<?php

namespace App\Livewire\Transaksi;

use App\Models\Karyawan;
use App\Models\Penggajian;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\withPagination;

#[Layout('components.layout.app')]
#[Title('Proses Penggajian')]
class PenggajianIndex extends Component
{
    use withPagination;

    public $bulan;
    public $tahun;
    public $search='';

    public function mount()
    {
        $this->bulan = date('M');
        $this->tahun = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    //reset page jika user mengganti bulan atau tahun filter
    
    public function updatedBulan() {$this->resetPage();}
    public function updatedTahun() {$this->resetPage();}
    public function render()
    {
        $penggajians = Penggajian::with('karyawan.departemen', 'karyawan.jabatan')
        ->where('bulan', $this->bulan)
        ->where('tahun', $this->tahun)
        ->when($this->search, function ($query){
            $query->whereHas('karyawan', function ($q){
                $q->where('nama', 'like', '%'. $this->search. '%')
                  ->orWhere('nik','like', '%'.$this->search.'%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(15);
        return view('livewire.transaksi.penggajian-index', compact('penggajians'));
    }

    //fungsi untuk membuka detail penggajians
    public function generatedpayroll()
    {
        //1.cek ada penggajians ada bulan di ataun 
        $sudahAda = Penggajian::where('bulan', $this->bulan)
        ->where('tahun', $this->tahun)
        ->exists();

        if($sudahAda){
            session()->flash('error', 'gagal gaji untuk periode' . $this->bulan . '/' . $this->tahun .  'sudah pernah diproses');
            return;
        }

       //2. karyawan aktif
       $karyawans = Karyawan::where('status', 'aktif')->get();
       if ($karyawans->isEmpty()) {
        session()->flash('error', 'gagal tidak ada karyawan aktif untuk digaji.');
        return;
       }

       //3. proses penggajian
       $count = 0;
       foreach ($karyawans as $karyawan){
           $potongan = $karyawan->gaji_pokok + 0.03;
           $total_gaji = ($karyawan->gaji_pokok + $karyawan->tunjangan) - $potongan;
           Penggajian::create([
            'karyawan_id'=> $karyawan->id,
            'bulan'=> $this->bulan,
            'tahun'=>$this->tahun,
            'tanggal_proses'=> date('Y-m-d'),
            'gaji_pokok'=>$karyawan->gaji_pokok,
            'tunjangan'=>$karyawan->tunjangan,
            'potongan'=>$potongan,
            'total_gaji'=>$total_gaji
           ]);
           $count++;
       }
       session()->flash('success', 'Berhasil Gaji untuk periode' . $this->bulan . '/' . $this->bulan . 'Telah diproses. Total karyawan yang digaji:' . $count);      
    }
    public function delete($id)
    {
        Penggajian::findorfail($id)->delete();
        session()->flash('message', 'Data penggajian berhasil dihapus');
    }
}
