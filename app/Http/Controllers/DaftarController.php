<?php

namespace App\Http\Controllers;

use App\Models\daftar;
use App\Http\Requests\StoredaftarRequest;
use App\Http\Requests\UpdatedaftarRequest;
use App\Models\pasien;
use App\Models\poli;
use Illuminate\Http\Request;

class DaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['daftar'] = \App\Models\daftar::latest()->paginate(10);
        return view('daftar.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['listPasien'] = pasien::orderBy('nama', 'asc')->get();
        $data['listPoli'] = poli::orderBy('nama', 'asc')->get();
        return view('daftar.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredaftarRequest $request)
    {
        $requestData = $request->validate([
            'tanggal_daftar' => 'required|date',
            'pasien_id' => 'required',
            'poli_id' => 'required',
            'keluhan' => 'required',
        ]);

        $daftar = new daftar();
        $daftar->fill($requestData);

        // Logika status pendaftaran
        $tanggalDaftar = new \DateTime($daftar->tanggal_daftar);
        $hariIni = new \DateTime();
        $selisih = $tanggalDaftar->diff($hariIni);

        if ($selisih->days === 0) {
            $daftar->status_daftar = 'baru'; // Pastikan status 'baru' hanya jika hari ini.
        }

        $daftar->save();

        flash("Data sudah disimpan")->success();
        return redirect()->route('daftar.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $daftar = daftar::findOrFail($id);
        return view('daftar.show', data: ['daftar' => $daftar]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(daftar $daftar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedaftarRequest $request,  $id)
    {
        $requestData = $request->validate([
            'tindakan' => 'required',
            'diagnosis' => 'required',
        ]);

        $daftar = daftar::findOrFail($id);
        $daftar->fill($requestData);
        $daftar->save();
        flash('Data berhasil disimpan')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $daftar = daftar::findOrFail($id);
        $daftar->delete();
        flash('Data sudah dihapus')->success();
        return back();
    }
}
