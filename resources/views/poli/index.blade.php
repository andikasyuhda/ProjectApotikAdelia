@extends('layouts.app_modern', ['title' => 'Data Poli'])
@section('content')
<div class="card">
    <h3 class="card-header">Data Poli</h3>
    <div class="card-body">
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <a href="/poli/create" class="btn btn-primary btn-sm">Tambah Pasien</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Biaya</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($polis as $poli)
                <tr>
                    <td>{{ $poli->id }}</td>
                    <td>{{ $poli->nama }}</td>
                    <td>{{ $poli->biaya }}</td>
                    <td>{{ $poli->keterangan }}</td>
                    <td>
                        <a href="/poli/{{ $poli->id }}/edit" class="btn btn-warning btn-sm ml-2">Edit</a>
                        <form action="{{ route('poli.destroy', $poli->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm ml-2" onclick="return confirm('Yakin ingin menghapus data')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{  $polis->links()  }}
    </div>
</div>
@endsection