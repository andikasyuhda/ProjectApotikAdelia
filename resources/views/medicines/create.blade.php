@extends('layouts.app')

@section('title', 'Tambah Obat - Sistem Stok Obat')

@section('content')
<div class="page-header" style="text-align: center; margin-bottom: 32px;">
    <h2 style="font-size: 28px;">Tambah Obat Baru</h2>
    <p>Tambahkan obat baru ke dalam sistem</p>
</div>

<div class="content-card" style="max-width: 600px; margin: 0 auto; padding: 32px 40px; background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
    <form action="{{ route('medicines.store') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 24px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                    <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Nama Obat
            </label>
            <input type="text" name="nama_obat" placeholder="Contoh: Paracetamol 500mg" required 
                   style="width: 100%; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 15px; transition: all 0.2s; box-sizing: border-box;"
                   onfocus="this.style.borderColor='var(--primary-pink)'; this.style.boxShadow='0 0 0 3px rgba(233,30,99,0.1)'"
                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div class="form-group">
                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Jumlah Stok
                </label>
                <input type="number" name="stok" placeholder="0" min="0" required 
                       style="width: 100%; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 15px; transition: all 0.2s; box-sizing: border-box;"
                       onfocus="this.style.borderColor='var(--primary-pink)'; this.style.boxShadow='0 0 0 3px rgba(233,30,99,0.1)'"
                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="10" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Lokasi
                </label>
                <input type="text" name="lokasi" placeholder="Rak A1" required 
                       style="width: 100%; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 15px; transition: all 0.2s; box-sizing: border-box;"
                       onfocus="this.style.borderColor='var(--primary-pink)'; this.style.boxShadow='0 0 0 3px rgba(233,30,99,0.1)'"
                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px; justify-content: flex-end;">
            <a href="{{ route('medicines.index') }}" class="btn-secondary" style="padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Batal
            </a>
            <button type="submit" class="btn-primary" style="padding: 14px 28px; border-radius: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Tambah Obat
            </button>
        </div>
    </form>
</div>
@endsection
