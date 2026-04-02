<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class pasienController extends Controller
{
    public function index()
    {
        $data['pasien'] = \App\Models\pasien::latest()->paginate(20);
        return view('pasien.index', $data);    
    }

    public function create()
    {
        return view('pasien.tambah');    
    }

    public function store(Request $request)
    {
        $requestData = $request->validate([
            'no_pasien' => 'required|unique:pasiens,no_pasien',
            'nama' => 'required|min:3',
            'umur' => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'nullable', //alamat boleh kosong
            'foto'=> 'required|image|mimes:jpeg,png,jpg|max:5000',
        ]);
        $pasien = new \App\Models\Pasien(); //membuat objek kosong di variabel model
        $pasien->fill($requestData); //mengisi var model dengan data yang sudah divalidasi requestData
        $pasien->foto= $request->file('foto')->store('public');
        $pasien->save();
        flash("Data sudah disimpan")->success(); //menyimpan data ke database
        return back();
        //mengarahkan user ke url sebelumnya yaitu /pasien/create dengan membawa variabel pesan
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data['pasien'] = \App\Models\pasien::findOrFail($id);
        return view('pasien.edit', $data);    

    }

    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'no_pasien' => 'required|unique:pasiens,no_pasien,' . $id,
            'nama' => 'required|min:3',
            'umur' => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'nullable', //alamat boleh kosong
            'foto'=> 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ]);
        $pasien = \App\Models\Pasien::findOrFail($id);
        $pasien->fill($requestData); //mengisi var model dengan data yang sudah divalidasi requestData
        if($request->hasFile('foto')){
            Storage::delete($pasien->foto);
            $pasien->foto = $request->file('foto')->store('public');
        }
        $pasien->save();
        flash("Data sudah disimpan")->success(); //menyimpan data ke database
        return back();
        //mengarahkan user ke url sebelumnya yaitu /pasien/create dengan membawa variabel pesan
    }

    public function destroy(string $id)
    {
        $pasien = \App\Models\Pasien::findOrfail($id);
        if ($pasien->daftar->count() >= 1) {
            flash('Data tidak bisa dihapus karena sudah terkait dengan data pendaftaran')->error();
            return back();
            }
        if ($pasien->foto != null && Storage::exists($pasien->foto)) {
            Storage::delete($pasien->foto);
        }
        $pasien->delete();
        flash('Data sudah dihapus')->success();
        return back();
    }
}
