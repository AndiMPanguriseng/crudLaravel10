<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(): View{
        $pegawais = Pegawai::oldest()->paginate();
        return view('pegawai', compact('pegawais'));
    }

    public function create(): View{
        return view('tambahpegawai');
    }

    public function store(Request $request): RedirectResponse {
        $this->validate($request, [
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'alamat' => 'required|min:5',
            'notelpon' => 'required|min:9',
        ]);

        $foto = $request->file('foto');
        $foto->storeAs('public/pegawai', $foto->hashName());

        pegawai::create([
            'foto' => $foto->hashName(),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'notelpon' => $request->notelpon
        ]);

        return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View{
        $pegawai = Pegawai::findOrFail($id);
        return view('detailPegawai', compact('pegawai'));
    }

    public function edit(string $id): View{
        $pegawai = Pegawai::findOrFail($id);
        return view('editPegawai', compact('pegawai'));
    }

    public function update(Request $request, $id): RedirectResponse{
        $this->validate($request, [
            'foto' => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama'     => 'required|min:5',
            'alamat'   => 'required|min:5',
            'notelpon'   => 'required|min:5' 
        ]);

        $pegawai = Pegawai::findOrFail($id);

        if ($request->hasFile('foto')){
            $foto = $request->file('foto');
            $foto->storeAs('public/pegawai', $foto->hashName());

            Storage::delete('public/pegawai'.$pegawai->foto);

            $pegawai->update([
                'foto'     => $foto->hashName(),
                'nama'     => $request->nama,
                'alamat'   => $request->alamat,
                'notelpon'   => $request->notelpon
            ]);
        }else{
            $pegawai->update([
                'nama'     => $request->nama,
                'alamat'   => $request->alamat,
                'notelpon'   => $request->notelpon
            ]);
        }
        return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse{
        $pegawai = Pegawai::findOrFail($id);

        Storage::delete('public/pegawai'. $pegawai->foto);

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}