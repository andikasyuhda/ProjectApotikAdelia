@extends('layouts.app')

@section('title', 'Daftar Obat - Sistem Stok Obat')

@section('content')
<div class="page-header">
    <h2>Daftar Obat</h2>
    <p>Lihat dan kelola daftar obat</p>
</div>

<!-- Search Bar with Autocomplete -->
<div class="search-box" style="position: relative;">
    <form action="{{ route('medicines.index') }}" method="GET" id="searchForm">
        <svg class="search-icon" width="18" height="18" viewBox="0 0 20 20" fill="none">
            <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="text" name="search" id="searchInput" placeholder="Cari nama obat atau lokasi..." value="{{ $search ?? '' }}" autocomplete="off">
        <input type="hidden" name="status" id="statusInput" value="{{ request('status', '') }}">
    </form>
    <!-- Autocomplete Dropdown -->
    <div id="autocompleteDropdown" style="
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        margin-top: 8px;
        max-height: 320px;
        overflow-y: auto;
        z-index: 50;
    "></div>
</div>

<!-- Filter Pills -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <a href="{{ route('medicines.index', array_merge(request()->only('search'), ['status' => ''])) }}" 
       style="padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
              {{ !request('status') ? 'background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink)); color: white;' : 'background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color);' }}">
        Semua <span style="margin-left: 4px; padding: 2px 8px; border-radius: 10px; font-size: 12px; {{ !request('status') ? 'background: rgba(255,255,255,0.2);' : 'background: var(--bg-main);' }}">{{ $totalCount ?? $medicines->total() }}</span>
    </a>
    <a href="{{ route('medicines.index', array_merge(request()->only('search'), ['status' => 'aman'])) }}" 
       style="padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
              {{ request('status') === 'aman' ? 'background: linear-gradient(135deg, #10B981, #059669); color: white;' : 'background: var(--bg-card); color: #10B981; border: 1px solid #D1FAE5;' }}">
        Stok Aman
    </a>
    <a href="{{ route('medicines.index', array_merge(request()->only('search'), ['status' => 'sedang'])) }}" 
       style="padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
              {{ request('status') === 'sedang' ? 'background: linear-gradient(135deg, #F59E0B, #D97706); color: white;' : 'background: var(--bg-card); color: #F59E0B; border: 1px solid #FEF3C7;' }}">
        Stok Sedang
    </a>
    <a href="{{ route('medicines.index', array_merge(request()->only('search'), ['status' => 'rendah'])) }}" 
       style="padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
              {{ request('status') === 'rendah' ? 'background: linear-gradient(135deg, #EF4444, #DC2626); color: white;' : 'background: var(--bg-card); color: #EF4444; border: 1px solid #FEE2E2;' }}">
        Stok Rendah
    </a>
</div>

<!-- Stock Level Legend -->
<div style="display: flex; gap: 24px; margin-bottom: 20px; padding: 14px 18px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 12px; flex-wrap: wrap;">
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #475569;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4M12 8h.01" stroke-linecap="round"/>
        </svg>
        <span style="font-weight: 600;">Keterangan:</span>
    </div>
    <div style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
        <span style="width: 10px; height: 10px; border-radius: 3px; background: #10B981;"></span>
        <span style="color: #10B981; font-weight: 600;">Aman</span>
        <span style="color: #64748b;">= lebih dari 100 unit</span>
    </div>
    <div style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
        <span style="width: 10px; height: 10px; border-radius: 3px; background: #F59E0B;"></span>
        <span style="color: #F59E0B; font-weight: 600;">Sedang</span>
        <span style="color: #64748b;">= 50 - 100 unit</span>
    </div>
    <div style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
        <span style="width: 10px; height: 10px; border-radius: 3px; background: #EF4444;"></span>
        <span style="color: #EF4444; font-weight: 600;">Rendah</span>
        <span style="color: #64748b;">= kurang dari 50 unit</span>
    </div>
</div>

<!-- Medicine Table -->
<div class="medicine-table">
    <div class="table-header">
        <a href="{{ route('medicines.index', array_merge(request()->all(), ['sort' => 'nama_obat', 'direction' => request('sort') === 'nama_obat' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" 
           style="color: white; text-decoration: none; display: flex; align-items: center; gap: 6px; cursor: pointer;">
            Nama Obat
            @if(request('sort') === 'nama_obat')
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="transition: transform 0.2s; {{ request('direction') === 'desc' ? 'transform: rotate(180deg);' : '' }}">
                    <path d="M18 15l-6-6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            @endif
        </a>
        <a href="{{ route('medicines.index', array_merge(request()->all(), ['sort' => 'stok', 'direction' => request('sort') === 'stok' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" 
           style="color: white; text-decoration: none; display: flex; align-items: center; gap: 6px; cursor: pointer;">
            Stok
            @if(request('sort') === 'stok')
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="transition: transform 0.2s; {{ request('direction') === 'desc' ? 'transform: rotate(180deg);' : '' }}">
                    <path d="M18 15l-6-6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            @endif
        </a>
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
            <button class="btn-icon" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0); color: #065F46;" onclick="openAdjustModal({{ $medicine->id }}, '{{ addslashes($medicine->nama_obat) }}', {{ $medicine->stok }})" title="Sesuaikan Stok">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <a href="{{ route('medicines.history', $medicine) }}" class="btn-icon" style="background: linear-gradient(135deg, #E0E7FF, #C7D2FE); color: #4338CA;" title="Riwayat Stok">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <button class="btn-icon btn-edit" onclick="openEditModal({{ $medicine->id }}, '{{ addslashes($medicine->nama_obat) }}', {{ $medicine->stok }}, '{{ addslashes($medicine->lokasi) }}')" title="Edit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="btn-icon btn-delete" onclick="deleteMedicine({{ $medicine->id }}, '{{ addslashes($medicine->nama_obat) }}')" title="Delete">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="10" y1="11" x2="10" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="14" y1="11" x2="14" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>
    @empty
    <div class="empty-state" style="text-align: center; padding: 60px 20px;">
        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" style="margin-bottom: 20px; opacity: 0.8;">
            <circle cx="60" cy="60" r="50" stroke="url(#emptyGrad)" stroke-width="2" fill="none" stroke-dasharray="8 4"/>
            <path d="M45 45L75 75M45 75L75 45" stroke="url(#emptyGrad)" stroke-width="3" stroke-linecap="round"/>
            <rect x="35" y="55" width="50" height="30" rx="4" stroke="url(#emptyGrad)" stroke-width="2" fill="none"/>
            <path d="M42 48L60 35L78 48" stroke="url(#emptyGrad)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <defs>
                <linearGradient id="emptyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#FF6B9D"/>
                    <stop offset="100%" style="stop-color:#C44569"/>
                </linearGradient>
            </defs>
        </svg>
        <h3 style="font-size: 20px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">
            {{ $search ? 'Tidak ditemukan' : 'Belum ada obat' }}
        </h3>
        <p style="color: var(--text-secondary); margin-bottom: 20px; max-width: 300px; margin-left: auto; margin-right: auto;">
            {{ $search ? 'Coba ubah kata kunci pencarian atau hapus filter yang aktif.' : 'Mulai tambahkan obat baru untuk mengelola stok apotek Anda.' }}
        </p>
        @if(!$search)
        <a href="{{ route('medicines.create') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink)); color: white; border-radius: 12px; text-decoration: none; font-weight: 600; transition: transform 0.2s;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Tambah Obat Pertama
        </a>
        @else
        <a href="{{ route('medicines.index') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 12px; text-decoration: none; font-weight: 600;">
            Hapus Filter
        </a>
        @endif
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($medicines->hasPages())
<div class="pagination-wrapper" style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; padding: 16px 0;">
    <div style="color: var(--text-secondary); font-size: 14px;">
        Menampilkan {{ $medicines->firstItem() }} - {{ $medicines->lastItem() }} dari {{ $medicines->total() }} obat
    </div>
    <div class="pagination" style="display: flex; gap: 8px;">
        {{-- Previous Page --}}
        @if($medicines->onFirstPage())
            <span style="padding: 10px 16px; background: var(--bg-main); border-radius: 10px; color: var(--text-muted); cursor: not-allowed;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                    <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        @else
            <a href="{{ $medicines->previousPageUrl() }}" style="padding: 10px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); text-decoration: none; transition: all 0.2s ease;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                    <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach($medicines->getUrlRange(max(1, $medicines->currentPage() - 2), min($medicines->lastPage(), $medicines->currentPage() + 2)) as $page => $url)
            @if($page == $medicines->currentPage())
                <span style="padding: 10px 16px; background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink)); border-radius: 10px; color: white; font-weight: 600; min-width: 44px; text-align: center;">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" style="padding: 10px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); text-decoration: none; transition: all 0.2s ease; min-width: 44px; text-align: center;">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next Page --}}
        @if($medicines->hasMorePages())
            <a href="{{ $medicines->nextPageUrl() }}" style="padding: 10px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); text-decoration: none; transition: all 0.2s ease;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                    <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        @else
            <span style="padding: 10px 16px; background: var(--bg-main); border-radius: 10px; color: var(--text-muted); cursor: not-allowed;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                    <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        @endif
    </div>
</div>
@endif

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
            <h2 style="color: #DC2626;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Konfirmasi Hapus
            </h2>
        </div>
        <div style="background: #FEF2F2; border: 1px solid #FEE2E2; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
            <div style="font-size: 14px; color: #991B1B; margin-bottom: 8px;">Anda akan menghapus obat:</div>
            <div id="deleteItemName" style="font-size: 18px; font-weight: 700; color: #DC2626;"></div>
        </div>
        <p style="color: #64748B; margin-bottom: 24px; font-size: 14px;">
            ⚠️ Tindakan ini tidak dapat dibatalkan. Semua riwayat stok terkait obat ini juga akan dihapus.
        </p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #DC2626, #991B1B);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px; vertical-align: middle;">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stock Adjustment Modal -->
<div class="modal" id="adjustModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Sesuaikan Stok</h2>
        </div>
        <div id="adjustMedicineName" style="font-size: 15px; color: var(--text-secondary); margin-bottom: 20px;"></div>
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 6px;">Stok Saat Ini</div>
            <div id="adjustCurrentStock" style="font-size: 42px; font-weight: 700; background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></div>
        </div>
        <form id="adjustForm" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Tipe Perubahan</label>
                <div style="display: flex; gap: 10px;">
                    <label style="flex: 1; padding: 14px; border: 2px solid var(--border-color); border-radius: 12px; cursor: pointer; text-align: center; transition: all 0.2s;">
                        <input type="radio" name="change_type" value="in" style="display: none;" onchange="updateAdjustType(this)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" style="margin-bottom: 4px;">
                            <path d="M12 19V5M5 12l7-7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div style="font-size: 13px; font-weight: 600; color: #10B981;">Stok Masuk</div>
                    </label>
                    <label style="flex: 1; padding: 14px; border: 2px solid var(--border-color); border-radius: 12px; cursor: pointer; text-align: center; transition: all 0.2s;">
                        <input type="radio" name="change_type" value="out" style="display: none;" onchange="updateAdjustType(this)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" style="margin-bottom: 4px;">
                            <path d="M12 5v14M19 12l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div style="font-size: 13px; font-weight: 600; color: #EF4444;">Stok Keluar</div>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="change_amount" id="adjust_amount" min="1" required placeholder="Masukkan jumlah">
            </div>

            <div class="form-group">
                <label>Catatan (opsional)</label>
                <input type="text" name="notes" placeholder="Contoh: Restok dari supplier">
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeAdjustModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
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

    function deleteMedicine(id, nama) {
        document.getElementById('deleteForm').action = `/medicines/${id}`;
        document.getElementById('deleteItemName').textContent = nama;
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

    document.getElementById('adjustModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAdjustModal();
        }
    });

    // Stock adjustment functions
    function openAdjustModal(id, nama, stok) {
        document.getElementById('adjustForm').action = `/medicines/${id}/adjust-stock`;
        document.getElementById('adjustMedicineName').textContent = nama;
        document.getElementById('adjustCurrentStock').textContent = stok;
        document.getElementById('adjust_amount').value = '';
        // Reset radio buttons
        document.querySelectorAll('#adjustModal input[name="change_type"]').forEach(r => {
            r.checked = false;
            r.closest('label').style.borderColor = 'var(--border-color)';
            r.closest('label').style.background = 'transparent';
        });
        document.getElementById('adjustModal').classList.add('active');
    }

    function closeAdjustModal() {
        document.getElementById('adjustModal').classList.remove('active');
    }

    function updateAdjustType(radio) {
        document.querySelectorAll('#adjustModal input[name="change_type"]').forEach(r => {
            r.closest('label').style.borderColor = 'var(--border-color)';
            r.closest('label').style.background = 'transparent';
        });
        if (radio.value === 'in') {
            radio.closest('label').style.borderColor = '#10B981';
            radio.closest('label').style.background = 'rgba(16, 185, 129, 0.1)';
        } else {
            radio.closest('label').style.borderColor = '#EF4444';
            radio.closest('label').style.background = 'rgba(239, 68, 68, 0.1)';
        }
    }

    // Search Autocomplete
    const searchInput = document.getElementById('searchInput');
    const dropdown = document.getElementById('autocompleteDropdown');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`/api/medicines/suggest?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        dropdown.style.display = 'none';
                        return;
                    }

                    dropdown.innerHTML = data.map(med => `
                        <div class="autocomplete-item" style="
                            padding: 14px 18px;
                            cursor: pointer;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            border-bottom: 1px solid #f1f5f9;
                            transition: background 0.15s;
                        " onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'" 
                           onclick="selectMedicine('${med.nama_obat.replace(/'/g, "\\'")}')">
                            <span style="font-weight: 500; color: #0f172a;">${highlightMatch(med.nama_obat, '${query}')}</span>
                            <span style="font-size: 13px; color: ${med.stok < 50 ? '#ef4444' : '#10b981'}; font-weight: 600;">${med.stok} unit</span>
                        </div>
                    `).join('');
                    dropdown.style.display = 'block';
                })
                .catch(() => {
                    dropdown.style.display = 'none';
                });
        }, 250);
    });

    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark style="background: #fef08a; padding: 0 2px; border-radius: 2px;">$1</mark>');
    }

    function selectMedicine(name) {
        searchInput.value = name;
        dropdown.style.display = 'none';
        document.getElementById('searchForm').submit();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-box')) {
            dropdown.style.display = 'none';
        }
    });

    // Keyboard navigation for search
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            dropdown.style.display = 'none';
        }
    });
</script>
@endpush
