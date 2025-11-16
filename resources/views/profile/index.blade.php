@extends('layouts.app')

@section('title', 'Profile - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Container form -->
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">Profile Saya</h1>

        <!-- Card form profile -->
        <div class="bg-white rounded-lg shadow p-6">
            <h5 class="text-xl font-bold mb-6">Update Profile</h5>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input nama -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border rounded @error('name') border-red-500 @enderror" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input email -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Garis pemisah -->
                <hr class="my-6 border-gray-300">

                <!-- Section ganti password -->
                <h5 class="text-lg font-bold mb-4">Ganti Password (Optional)</h5>

                <!-- Input password saat ini -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Password Saat Ini</label>
                    <input type="password" class="w-full px-4 py-2 border rounded @error('current_password') border-red-500 @enderror" name="current_password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input password baru -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Password Baru</label>
                    <input type="password" class="w-full px-4 py-2 border rounded @error('password') border-red-500 @enderror" name="password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input konfirmasi password baru -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" class="w-full px-4 py-2 border rounded" name="password_confirmation">
                </div>

                <!-- Tombol update -->
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection
