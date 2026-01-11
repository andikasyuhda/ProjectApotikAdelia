@extends('layouts.app')

@section('title', 'Dashboard - SIPESOB')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <h2 style="font-size: 26px; font-weight: 700; color: #0F172A;">Dashboard</h2>
    <p style="color: #64748B;">Ringkasan sistem pencarian stok obat</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:24px;">
    @php
        $stats = [
            ['title'=>'Total Jenis Obat','value'=>$totalJenisObat,'color'=>'#3B82F6'],
            ['title'=>'Total Stok','value'=>$totalStok,'color'=>'#10B981'],
            ['title'=>'Stok Rendah','value'=>$stokRendah,'color'=>'#EF4444'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="stat-card" style="
        background:#fff;
        border-radius:14px;
        padding:20px;
        box-shadow:0 10px 25px rgba(15,23,42,.06);
        display:flex;
        justify-content:space-between;
        align-items:center;
        transition:.3s;
    ">
        <div>
            <div style="font-size:13px;color:#64748B;">{{ $stat['title'] }}</div>
            <div style="font-size:30px;font-weight:800;color:#0F172A;margin-top:6px;">
                {{ $stat['value'] }}
            </div>
        </div>
        <div style="
            width:48px;
            height:48px;
            border-radius:12px;
            background:{{ $stat['color'] }}20;
            display:flex;
            align-items:center;
            justify-content:center;
        ">
            <div style="width:14px;height:14px;border-radius:50%;background:{{ $stat['color'] }}"></div>
        </div>
    </div>
    @endforeach
</div>

<!-- Main Content -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
    <!-- Recent Medicines -->
    <div class="content-card" style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 10px 25px rgba(15,23,42,.06);">
        <h3 style="font-size:16px;font-weight:700;color:#0F172A;">Obat Terbaru Ditambahkan</h3>

        @if($recentMedicines->count())
            <div style="margin-top:16px;">
                @foreach($recentMedicines as $medicine)
                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    padding:14px 0;
                    border-bottom:1px dashed #E2E8F0;
                ">
                    <div>
                        <div style="font-weight:600;color:#0F172A;">{{ $medicine->nama_obat }}</div>
                        <div style="font-size:12px;color:#64748B;">{{ $medicine->lokasi }}</div>
                    </div>
                    <div style="font-weight:700;color:#3B82F6;">
                        {{ $medicine->stok }} <span style="font-size:12px;color:#94A3B8;">unit</span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p style="text-align:center;color:#94A3B8;padding:30px;">Belum ada data obat</p>
        @endif
    </div>

    <!-- Low Stock -->
    <div class="content-card" style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 10px 25px rgba(15,23,42,.06);">
        <h3 style="font-size:16px;font-weight:700;color:#DC2626;">⚠ Peringatan Stok Rendah</h3>

        @if($lowStockMedicines->count())
            <div style="margin-top:16px;">
                @foreach($lowStockMedicines as $medicine)
                <div style="
                    background:#FEF2F2;
                    border-left:4px solid #EF4444;
                    padding:12px;
                    border-radius:10px;
                    margin-bottom:10px;
                ">
                    <div style="font-weight:600;">{{ $medicine->nama_obat }}</div>
                    <div style="font-size:12px;color:#DC2626;">{{ $medicine->stok }} unit tersisa</div>
                </div>
                @endforeach
            </div>
        @else
            <p style="text-align:center;color:#94A3B8;padding:30px;">Semua stok aman</p>
        @endif
    </div>
</div>

<!-- Bottom Stats -->
<div style="margin-top:24px;display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    @php
        $bottomStats = [
            ['label'=>'Jenis Obat','value'=>$totalJenisObat,'color'=>'#3B82F6'],
            ['label'=>'Total Unit','value'=>$totalStok,'color'=>'#10B981'],
            ['label'=>'Stok Rendah','value'=>$stokRendah,'color'=>'#EF4444'],
            ['label'=>'Stok Aman','value'=>$totalJenisObat - $stokRendah,'color'=>'#0F172A'],
        ];
    @endphp

    @foreach($bottomStats as $bs)
    <div style="
        background:#fff;
        border-radius:14px;
        padding:20px;
        text-align:center;
        box-shadow:0 10px 25px rgba(15,23,42,.06);
    ">
        <div style="font-size:26px;font-weight:800;color:{{ $bs['color'] }};">
            {{ $bs['value'] }}
        </div>
        <div style="font-size:12px;color:#64748B;margin-top:6px;">
            {{ $bs['label'] }}
        </div>
    </div>
    @endforeach
</div>
@endsection
