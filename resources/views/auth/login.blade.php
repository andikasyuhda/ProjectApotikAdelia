@extends('layouts.app')

@section('title', 'Login - SIPESOB')

@section('content')
<div style="
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #FF6B9D 0%, #E91E63 100%);
    padding: 20px;
">
    <div style="
        background: white;
        border-radius: 24px;
        box-shadow: 0 24px 64px rgba(233, 30, 99, 0.2);
        max-width: 460px;
        width: 100%;
        padding: 48px 40px;
    ">
        <!-- Logo & Brand -->
        <div style="text-align: center; margin-bottom: 36px;">
            <div style="
                width: 72px;
                height: 72px;
                background: linear-gradient(135deg, #FF6B9D, #E91E63);
                border-radius: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
                box-shadow: 0 8px 24px rgba(255, 107, 157, 0.3);
            ">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1 style="
                font-size: 28px;
                font-weight: 700;
                background: linear-gradient(135deg, #FF6B9D, #E91E63);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 8px;
            ">SIPESOB</h1>
            <p style="
                font-size: 14px;
                color: #64748B;
                font-weight: 500;
            ">Sistem Pencarian Stok Obat Berbasis Web</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom: 24px;">
                <label for="email" style="
                    display: block;
                    font-size: 14px;
                    font-weight: 600;
                    color: #1E293B;
                    margin-bottom: 10px;
                ">Email</label>
                <div style="position: relative;">
                    <svg style="
                        position: absolute;
                        left: 16px;
                        top: 50%;
                        transform: translateY(-50%);
                        width: 20px;
                        height: 20px;
                        color: #94A3B8;
                    " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        style="
                            width: 100%;
                            padding: 14px 16px 14px 48px;
                            border: 2px solid {{ $errors->has('email') ? '#EF4444' : '#E2E8F0' }};
                            border-radius: 12px;
                            font-size: 15px;
                            transition: all 0.3s ease;
                        "
                        placeholder="nama@email.com"
                        onfocus="this.style.borderColor='#FF6B9D'; this.style.boxShadow='0 0 0 4px rgba(255, 107, 157, 0.1)';"
                        onblur="this.style.borderColor='#E2E8F0'; this.style.boxShadow='none';"
                    >
                </div>
                @error('email')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom: 24px;">
                <label for="password" style="
                    display: block;
                    font-size: 14px;
                    font-weight: 600;
                    color: #1E293B;
                    margin-bottom: 10px;
                ">Password</label>
                <div style="position: relative;">
                    <svg style="
                        position: absolute;
                        left: 16px;
                        top: 50%;
                        transform: translateY(-50%);
                        width: 20px;
                        height: 20px;
                        color: #94A3B8;
                    " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 11V7a5 5 0 0110 0v4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        style="
                            width: 100%;
                            padding: 14px 16px 14px 48px;
                            border: 2px solid {{ $errors->has('password') ? '#EF4444' : '#E2E8F0' }};
                            border-radius: 12px;
                            font-size: 15px;
                            transition: all 0.3s ease;
                        "
                        placeholder="••••••••"
                        onfocus="this.style.borderColor='#FF6B9D'; this.style.boxShadow='0 0 0 4px rgba(255, 107, 157, 0.1)';"
                        onblur="this.style.borderColor='#E2E8F0'; this.style.boxShadow='none';"
                    >
                </div>
                @error('password')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 28px;
            ">
                <label style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    cursor: pointer;
                    font-size: 14px;
                    color: #64748B;
                ">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                        style="
                            width: 18px;
                            height: 18px;
                            border-radius: 6px;
                            border: 2px solid #E2E8F0;
                            cursor: pointer;
                        "
                    >
                    Ingat Saya
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="
                        font-size: 14px;
                        color: #FF6B9D;
                        text-decoration: none;
                        font-weight: 600;
                    ">Lupa Password?</a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" style="
                width: 100%;
                padding: 16px;
                background: linear-gradient(135deg, #FF6B9D, #E91E63);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(255, 107, 157, 0.3);
            "
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(255, 107, 157, 0.4)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(255, 107, 157, 0.3)';"
            >
                Masuk
            </button>

            <!-- Register Link -->
            <p style="
                text-align: center;
                margin-top: 24px;
                font-size: 14px;
                color: #64748B;
            ">
                Belum punya akun? 
                <a href="{{ route('register') }}" style="
                    color: #FF6B9D;
                    text-decoration: none;
                    font-weight: 600;
                ">Daftar Sekarang</a>
            </p>
        </form>
    </div>
</div>
@endsection
