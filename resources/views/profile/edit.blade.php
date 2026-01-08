@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gray-50 py-12 px-4 font-sans">
    <div class="max-w-4xl mx-auto">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-normal text-gray-900">Data & Privasi</h1>
            <p class="text-gray-600 mt-2">Kelola informasi, keamanan, dan data Anda untuk membuat layanan kami bekerja lebih baik bagi Anda.</p>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="p-8">
                    <div class="flex items-start gap-6">
                        <div class="flex-1">
                            <h2 class="text-xl font-medium text-gray-900 mb-2">Informasi Profil</h2>
                            <p class="text-sm text-gray-600 mb-6">Ubah nama akun dan alamat email Anda.</p>
                            
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="p-8">
                    <div class="flex items-start gap-6">
                        <div class="flex-1">
                            <h2 class="text-xl font-medium text-gray-900 mb-2">Keamanan Akun</h2>
                            <p class="text-sm text-gray-600 mb-6">Pastikan kata sandi Anda kuat dan diperbarui secara berkala.</p>
                            
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-red-500">
                <div class="p-8">
                    <div class="flex items-start gap-6">
                        <div class="hidden sm:block">
                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        
                        <div class="flex-1">
                            <h2 class="text-xl font-medium text-gray-900 mb-2">Hapus akun Anda</h2>
                            <p class="text-sm text-gray-600 mb-6">Menghapus akun akan menghapus semua data dan akses Anda secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                            
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-10 text-center">
            <a href="/dashboard" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection