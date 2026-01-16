@extends('layouts.app')

@section('title', 'Riwayat Stok - ' . $medicine->nama_obat)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2>Riwayat Stok</h2>
            <p>{{ $medicine->nama_obat }}</p>
        </div>
        <a href="{{ route('medicines.index') }}" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Current Stock Info -->
<div class="content-card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin-bottom: 8px;">Stok Saat Ini</h3>
            <div style="display: flex; align-items: baseline; gap: 8px;">
                <span style="font-size: 48px; font-weight: 700; background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $medicine->stok }}
                </span>
                <span style="font-size: 18px; color: var(--text-secondary);">unit</span>
            </div>
        </div>
        <span class="status-badge {{ $medicine->stock_status }}" style="font-size: 14px; padding: 10px 20px;">
            {{ $medicine->stock_label }}
        </span>
    </div>
</div>

<!-- History Timeline -->
<div class="content-card">
    <h3 style="margin-bottom: 24px;">Riwayat Perubahan</h3>
    
    @forelse($histories as $history)
    <div style="display: flex; gap: 20px; padding: 20px 0; border-bottom: 1px solid var(--border-color);">
        <!-- Timeline indicator -->
        <div style="display: flex; flex-direction: column; align-items: center;">
            <div style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; 
                @if($history->change_type === 'in') background: linear-gradient(135deg, #D1FAE5, #A7F3D0); color: #065F46;
                @elseif($history->change_type === 'out') background: linear-gradient(135deg, #FEE2E2, #FECACA); color: #991B1B;
                @else background: linear-gradient(135deg, #FEF3C7, #FDE68A); color: #92400E; @endif">
                @if($history->change_type === 'in')
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 19V5M5 12l7-7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                @elseif($history->change_type === 'out')
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 5v14M19 12l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                @else
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                @endif
            </div>
        </div>
        
        <!-- Content -->
        <div style="flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <div>
                    <span style="font-weight: 600; font-size: 15px; color: var(--text-primary);">
                        {{ $history->change_type_label }}
                    </span>
                    <span style="margin-left: 12px; font-size: 14px; color: 
                        @if($history->change_amount > 0) #10B981 @elseif($history->change_amount < 0) #EF4444 @else var(--text-secondary) @endif; font-weight: 600;">
                        {{ $history->change_amount > 0 ? '+' : '' }}{{ $history->change_amount }} unit
                    </span>
                </div>
                <span style="font-size: 13px; color: var(--text-muted);">
                    {{ $history->created_at->format('d M Y, H:i') }}
                </span>
            </div>
            
            <div style="display: flex; gap: 20px; font-size: 14px; color: var(--text-secondary); margin-bottom: 8px;">
                <span>Stok sebelum: <strong>{{ $history->previous_stock }}</strong></span>
                <span>→</span>
                <span>Stok sesudah: <strong>{{ $history->new_stock }}</strong></span>
            </div>
            
            @if($history->notes)
            <div style="font-size: 14px; color: var(--text-secondary); background: var(--bg-main); padding: 10px 14px; border-radius: 8px; margin-top: 8px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ $history->notes }}
            </div>
            @endif
            
            <div style="font-size: 13px; color: var(--text-muted); margin-top: 10px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ $history->user->name ?? 'System' }}
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <svg width="70" height="70" viewBox="0 0 24 24" fill="none">
            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p>Belum ada riwayat perubahan stok</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($histories->hasPages())
<div class="pagination-wrapper" style="margin-top: 24px; display: flex; justify-content: center;">
    <div class="pagination" style="display: flex; gap: 8px;">
        @if(!$histories->onFirstPage())
        <a href="{{ $histories->previousPageUrl() }}" style="padding: 10px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); text-decoration: none;">Previous</a>
        @endif
        @if($histories->hasMorePages())
        <a href="{{ $histories->nextPageUrl() }}" style="padding: 10px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); text-decoration: none;">Next</a>
        @endif
    </div>
</div>
@endif
@endsection
