@extends('layouts.app')

@section('title', 'Daftar Obat - Sistem Stok Obat')

@section('content')
<div class="page-header">
    <h2>Daftar Obat</h2>
    <p>Lihat dan kelola daftar obat</p>
</div>

<!-- Search Bar -->
<div class="search-box">
    <form action="{{ route('medicines.index') }}" method="GET">
        <svg class="search-icon" width="18" height="18" viewBox="0 0 20 20" fill="none">
            <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="text" name="search" placeholder="Cari nama obat atau lokasi..." value="{{ $search ?? '' }}">
    </form>
</div>

<!-- Medicine Table -->
<div class="medicine-table">
    <div class="table-header">
        <div>Nama Obat</div>
        <div>Stok</div>
        <div>Status</div>
        <div>Lokasi</div>
        <div>Aksi</div>
    </div>
    @forelse($medicines as $medicine)
    <div class="table-row">
        <div class="medicine-info">
            <div class="medicine-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span class="medicine-name">{{ $medicine->nama_obat }}</span>
        </div>
        <div>
            <span class="stock-value">{{ $medicine->stok }}</span>
            <span class="stock-unit">unit</span>
        </div>
        <div>
            <span class="status-badge {{ $medicine->stock_status }}">
                {{ $medicine->stock_label }}
            </span>
        </div>
        <div class="location-text">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ $medicine->lokasi }}
        </div>
        <div class="action-buttons">
            <button class="btn-icon btn-edit" onclick="openEditModal({{ $medicine->id }}, '{{ addslashes($medicine->nama_obat) }}', {{ $medicine->stok }}, '{{ addslashes($medicine->lokasi) }}')" title="Edit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="btn-icon btn-delete" onclick="deleteMedicine({{ $medicine->id }})" title="Delete">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="10" y1="11" x2="10" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="14" y1="11" x2="14" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <svg width="70" height="70" viewBox="0 0 24 24" fill="none">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p>Tidak ada data obat</p>
    </div>
    @endforelse
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Obat</h2>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Obat</label>
                <input type="text" name="nama_obat" id="edit_nama_obat" required>
            </div>

            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="stok" id="edit_stok" min="0" required>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" id="edit_lokasi" required>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Konfirmasi Hapus</h2>
        </div>
        <p style="color: #64748B; margin-bottom: 24px;">Apakah Anda yakin ingin menghapus obat ini? Tindakan ini tidak dapat dibatalkan.</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button type="submit" class="btn-primary" style="background: #DC2626;">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(id, nama, stok, lokasi) {
        document.getElementById('editForm').action = `/medicines/${id}`;
        document.getElementById('edit_nama_obat').value = nama;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_lokasi').value = lokasi;
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function deleteMedicine(id) {
        document.getElementById('deleteForm').action = `/medicines/${id}`;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Close modals on backdrop click
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush
