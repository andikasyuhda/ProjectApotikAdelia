<?php

namespace App\Http\Controllers;

use App\Models\poli;
use App\Http\Requests\StorepoliRequest;
use App\Http\Requests\UpdatepoliRequest;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $polis = poli::latest()->paginate(10);
        return view('poli.index', compact('polis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('poli.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepoliRequest $request)
    {
        $requestData = $request->validate([
            'nama' => 'required',
            'biaya' => 'required',
            'keterangan' => 'required',
        ]);

        $poli = new poli();
        $poli->fill($requestData);
        $poli->save();

        flash('Data berhasil disimpan')->success();

        return redirect()->route('poli.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(poli $poli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(poli $poli)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepoliRequest $request, poli $poli)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poli = poli::findOrfail($id);
        if($poli->daftar->count() >= 1){
            flash('Data tidak bisa dihapus karena sudah terkait dengan data pendaftaran')->error();
            return back();
        }

        $poli->delete();
        flash('Data sudah dihapus')->success();
        return back();
    }
}
