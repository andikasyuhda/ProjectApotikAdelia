@extends('layouts.app_modern', ['title' => 'Data Pasien Terdaftar'])
@section('content')
<div class="card">
    <h3 class="card-header">Data Daftar</h3>
    <div class="card-body">
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <a href="/daftar/create" class="btn btn-primary btn-sm">Tambah Data</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Daftar</th>
                    <th>Poli_id</th>
                    <th>Keluhan</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftar as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->pasien->nama }}</td>
                    <td>{{ ($item->pasien->jenis_kelamin) }}</td>
                    <td>{{ $item->tanggal_daftar }}</td>
                    <td>{{ $item->poli->id }}</td>
                    <td>{{ $item->keluhan }}</td>
                    <td>
                        <a href="/daftar/{{ $item->id }}" class="btn btn-info btn-sm">Detail</a>
                        <form action="/daftar/{{ $item->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm ml-2" onclick="return confirm('Yakin ingin menghapus data')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{  $daftar->links()  }}
    </div>
</div>
@endsection