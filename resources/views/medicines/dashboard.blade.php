<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Pencarian Stok Obat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', sans-serif;
            background: #F5F7FA;
            color: #1E293B;
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .header-title h1 {
            font-size: 32px;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
        }

        .header-subtitle {
            font-size: 15px;
            color: #64748B;
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            padding: 0 12px;
        }

        .btn-logout {
            padding: 10px 20px;
            background: #F1F5F9;
            color: #64748B;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #E2E8F0;
            color: #475569;
        }

        .btn-add {
            background: #3B82F6;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-add:hover {
            background: #2563EB;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Search Bar */
        .search-container {
            margin-bottom: 32px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            font-size: 15px;
            background: white;
            transition: all 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }

        .stat-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .stat-info h3 {
            font-size: 14px;
            color: #64748B;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-info p {
            font-size: 40px;
            font-weight: 700;
            color: #0F172A;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.blue {
            background: #DBEAFE;
        }

        .stat-icon.green {
            background: #D1FAE5;
        }

        .stat-icon.red {
            background: #FEE2E2;
        }

        /* Medicine Table */
        .medicine-table {
            background: white;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            overflow: hidden;
        }

        .table-header {
            display: grid;
            grid-template-columns: 2.5fr 1fr 1.2fr 1.8fr 0.8fr;
            padding: 18px 24px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            font-weight: 600;
            font-size: 14px;
            color: #475569;
        }

        .table-row {
            display: grid;
            grid-template-columns: 2.5fr 1fr 1.2fr 1.8fr 0.8fr;
            padding: 20px 24px;
            border-bottom: 1px solid #F1F5F9;
            align-items: center;
            transition: background 0.2s;
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row:hover {
            background: #F8FAFC;
        }

        .medicine-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .medicine-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #EFF6FF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .medicine-name {
            font-size: 15px;
            font-weight: 600;
            color: #0F172A;
        }

        .stock-value {
            font-size: 15px;
            font-weight: 600;
            color: #0F172A;
        }

        .stock-unit {
            font-size: 14px;
            color: #94A3B8;
            margin-left: 4px;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.aman {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-badge.sedang {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-badge.rendah {
            background: #FEE2E2;
            color: #991B1B;
        }

        .location-text {
            font-size: 14px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #DBEAFE;
            color: #2563EB;
        }

        .btn-edit:hover {
            background: #BFDBFE;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #FEE2E2;
            color: #DC2626;
        }

        .btn-delete:hover {
            background: #FECACA;
            transform: translateY(-1px);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 520px;
            width: 100%;
            padding: 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            margin-bottom: 28px;
        }

        .modal-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group input::placeholder {
            color: #CBD5E1;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-cancel {
            flex: 1;
            padding: 14px 24px;
            border: 1px solid #E2E8F0;
            background: white;
            color: #64748B;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        .btn-submit {
            flex: 1;
            padding: 14px 24px;
            background: #3B82F6;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #2563EB;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .empty-state {
            padding: 80px 20px;
            text-align: center;
            color: #94A3B8;
        }

        .empty-state svg {
            margin: 0 auto 20px;
            opacity: 0.4;
        }

        @media (max-width: 968px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-header,
            .table-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .table-header {
                display: none;
            }

            .action-buttons {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-title">
                <h1>Sistem Pencarian Stok Obat</h1>
                <p class="header-subtitle">Kelola dan pantau stok obat dengan mudah</p>
            </div>
            <div class="header-actions">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
                <button class="btn-add" onclick="openAddModal()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Tambah Obat
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="{{ route('medicines.index') }}" method="GET">
                <div class="search-box">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari nama obat atau lokasi..." value="{{ $search ?? '' }}">
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Jenis Obat</h3>
                    <p>{{ $totalJenisObat }}</p>
                </div>
                <div class="stat-icon blue">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Stok</h3>
                    <p>{{ $totalStok }}</p>
                </div>
                <div class="stat-icon green">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Stok Rendah</h3>
                    <p>{{ $medicines->filter(fn($m) => $m->stock_status === 'rendah')->count() }}</p>
                </div>
                <div class="stat-icon red">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="#EF4444" stroke-width="2"/>
                        <path d="M12 8v4M12 16h.01" stroke="#EF4444" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
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
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ $medicine->lokasi }}
                </div>
                <div class="action-buttons">
                    <button class="btn-icon btn-edit" onclick="openEditModal({{ $medicine->id }}, '{{ $medicine->nama_obat }}', {{ $medicine->stok }}, '{{ $medicine->lokasi }}')" title="Edit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="btn-icon btn-delete" onclick="deleteMedicine({{ $medicine->id }})" title="Delete">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="10" y1="11" x2="10" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="14" y1="11" x2="14" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p>Tidak ada data obat</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="medicineModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Obat Baru</h2>
            </div>
            <form id="medicineForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="form-group">
                    <label>Nama Obat</label>
                    <input type="text" name="nama_obat" id="nama_obat" placeholder="Contoh: Paracetamol 500mg" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok" id="stok" placeholder="Masukkan jumlah stok" min="0" required>
                </div>

                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" placeholder="Contoh: Rak A1 - Lantai 1" required>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-submit" id="submitBtn">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Obat Baru';
            document.getElementById('medicineForm').action = '{{ route("medicines.store") }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('nama_obat').value = '';
            document.getElementById('stok').value = '';
            document.getElementById('lokasi').value = '';
            document.getElementById('submitBtn').textContent = 'Tambah';
            document.getElementById('medicineModal').classList.add('active');
        }

        function openEditModal(id, nama, stok, lokasi) {
            document.getElementById('modalTitle').textContent = 'Edit Obat';
            document.getElementById('medicineForm').action = `/medicines/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('nama_obat').value = nama;
            document.getElementById('stok').value = stok;
            document.getElementById('lokasi').value = lokasi;
            document.getElementById('submitBtn').textContent = 'Perbarui';
            document.getElementById('medicineModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('medicineModal').classList.remove('active');
        }

        function deleteMedicine(id) {
            if (confirm('Apakah Anda yakin ingin menghapus obat ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/medicines/${id}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modal on backdrop click
        document.getElementById('medicineModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
