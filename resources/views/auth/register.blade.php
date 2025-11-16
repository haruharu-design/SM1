@extends('layouts.app')

@section('title', 'Signup - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Container form -->
    <div class="max-w-md mx-auto">
        <!-- Card form signup -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Signup</h2>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Input nama -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border rounded @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input email -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input password -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-2 border rounded @error('password') border-red-500 @enderror" name="password" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input konfirmasi password -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Konfirmasi Password</label>
                    <input type="password" class="w-full px-4 py-2 border rounded" name="password_confirmation" required>
                </div>

                <!-- Tombol daftar -->
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">Daftar</button>
            </form>

            <!-- Link login -->
            <div class="text-center">
                <p class="text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-bold">Login di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
