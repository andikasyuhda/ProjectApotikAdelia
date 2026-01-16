@extends('layouts.app')

@section('title', 'Dashboard - ADELY')

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

<!-- Stock Distribution Chart -->
@php
    $stokAman = \App\Models\Medicine::where('stok', '>', 100)->count();
    $stokSedang = \App\Models\Medicine::whereBetween('stok', [50, 100])->count();
    $total = $totalJenisObat ?: 1;
    $amanPct = round($stokAman / $total * 100);
    $sedangPct = round($stokSedang / $total * 100);
    $rendahPct = round($stokRendah / $total * 100);
@endphp
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 24px;">
    <!-- Doughnut Chart -->
    <div class="content-card" style="background:#fff;border-radius:14px;padding:24px;box-shadow:0 10px 25px rgba(15,23,42,.06);">
        <h3 style="font-size:16px;font-weight:700;color:#0F172A;margin-bottom:20px;">Distribusi Stok</h3>
        <div style="position: relative; width: 160px; height: 160px; margin: 0 auto;">
            <!-- CSS Doughnut Chart -->
            <div style="
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background: conic-gradient(
                    #10B981 0deg {{ $amanPct * 3.6 }}deg,
                    #F59E0B {{ $amanPct * 3.6 }}deg {{ ($amanPct + $sedangPct) * 3.6 }}deg,
                    #EF4444 {{ ($amanPct + $sedangPct) * 3.6 }}deg 360deg
                );
                position: relative;
            ">
                <div style="
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 100px;
                    height: 100px;
                    background: white;
                    border-radius: 50%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                ">
                    <div style="font-size: 28px; font-weight: 800; color: #0F172A;">{{ $totalJenisObat }}</div>
                    <div style="font-size: 11px; color: #64748B;">Total Obat</div>
                </div>
            </div>
        </div>
        <!-- Legend -->
        <div style="display: flex; justify-content: center; gap: 16px; margin-top: 20px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 6px;">
                <div style="width: 12px; height: 12px; border-radius: 3px; background: #10B981;"></div>
                <span style="font-size: 12px; color: #64748B;">Aman ({{ $stokAman }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <div style="width: 12px; height: 12px; border-radius: 3px; background: #F59E0B;"></div>
                <span style="font-size: 12px; color: #64748B;">Sedang ({{ $stokSedang }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <div style="width: 12px; height: 12px; border-radius: 3px; background: #EF4444;"></div>
                <span style="font-size: 12px; color: #64748B;">Rendah ({{ $stokRendah }})</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats Bar Chart -->
    <div class="content-card" style="background:#fff;border-radius:14px;padding:24px;box-shadow:0 10px 25px rgba(15,23,42,.06);">
        <h3 style="font-size:16px;font-weight:700;color:#0F172A;margin-bottom:20px;">Persentase Stok</h3>
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <!-- Aman Bar -->
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="font-size: 14px; font-weight: 600; color: #10B981;">Stok Aman (>100)</span>
                    <span style="font-size: 14px; font-weight: 600; color: #10B981;">{{ $amanPct }}%</span>
                </div>
                <div style="height: 12px; background: #E5E7EB; border-radius: 6px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $amanPct }}%; background: linear-gradient(90deg, #10B981, #34D399); border-radius: 6px; transition: width 1s ease;"></div>
                </div>
            </div>
            <!-- Sedang Bar -->
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="font-size: 14px; font-weight: 600; color: #F59E0B;">Stok Sedang (50-100)</span>
                    <span style="font-size: 14px; font-weight: 600; color: #F59E0B;">{{ $sedangPct }}%</span>
                </div>
                <div style="height: 12px; background: #E5E7EB; border-radius: 6px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $sedangPct }}%; background: linear-gradient(90deg, #F59E0B, #FBBF24); border-radius: 6px; transition: width 1s ease;"></div>
                </div>
            </div>
            <!-- Rendah Bar -->
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="font-size: 14px; font-weight: 600; color: #EF4444;">Stok Rendah (<50)</span>
                    <span style="font-size: 14px; font-weight: 600; color: #EF4444;">{{ $rendahPct }}%</span>
                </div>
                <div style="height: 12px; background: #E5E7EB; border-radius: 6px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $rendahPct }}%; background: linear-gradient(90deg, #EF4444, #F87171); border-radius: 6px; transition: width 1s ease;"></div>
                </div>
            </div>
        </div>
    </div>
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size:16px;font-weight:700;color:#DC2626;margin:0;">⚠ Peringatan Stok Rendah</h3>
            @if($lowStockMedicines->count())
            <span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                {{ $lowStockMedicines->count() }} item
            </span>
            @endif
        </div>

        @if($lowStockMedicines->count())
            <div style="max-height: 320px; overflow-y: auto; padding-right: 8px;">
                @foreach($lowStockMedicines->take(10) as $medicine)
                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    background:#FEF2F2;
                    border-left:4px solid #EF4444;
                    padding:10px 12px;
                    border-radius:8px;
                    margin-bottom:8px;
                ">
                    <div style="font-weight:600;font-size:14px;">{{ $medicine->nama_obat }}</div>
                    <div style="font-size:13px;color:#DC2626;font-weight:600;white-space:nowrap;">{{ $medicine->stok }} unit</div>
                </div>
                @endforeach
                @if($lowStockMedicines->count() > 10)
                <a href="{{ route('medicines.index', ['status' => 'rendah']) }}" style="display:block;text-align:center;padding:12px;color:#DC2626;text-decoration:none;font-weight:600;font-size:14px;">
                    Lihat semua {{ $lowStockMedicines->count() }} item →
                </a>
                @endif
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
