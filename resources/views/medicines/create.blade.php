@extends('layouts.app')

@section('title', 'Tambah Obat - Sistem Stok Obat')

@section('content')
<div class="page-header">
    <h2>Tambah Obat Baru</h2>
    <p>Tambahkan obat baru ke dalam sistem</p>
</div>

<div class="content-card" style="max-width: 700px;">
    <form action="{{ route('medicines.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama Obat</label>
            <input type="text" name="nama_obat" placeholder="Contoh: Paracetamol 500mg" required>
        </div>

        <div class="form-group">
            <label>Jumlah Stok</label>
            <input type="number" name="stok" placeholder="Masukkan jumlah stok" min="0" required>
        </div>

        <div class="form-group">
            <label>Lokasi (Otomatis)</label>
            <input type="text" name="lokasi" placeholder="Otomatis terisi (Rak A, Rak B, dst.)" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
            <small style="color: #64748B; font-size: 0.8rem; margin-top: 4px; display: block;">Rak akan otomatis menyesuaikan dengan huruf pertama nama obat.</small>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 28px;">
            <a href="{{ route('medicines.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Tambah Obat</button>
        </div>
    </form>
</div>
@endsection
