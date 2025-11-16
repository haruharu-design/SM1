@extends('layouts.app')

@section('title', 'Login - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Container form -->
    <div class="max-w-md mx-auto">
        <!-- Card form login -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Input email -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autofocus>
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

                <!-- Checkbox remember me -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" class="mr-2" id="remember" name="remember">
                    <label class="text-sm" for="remember">Remember me</label>
                </div>

                <!-- Tombol login -->
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">Login</button>
            </form>

            <!-- Link register -->
            <div class="text-center">
                <p class="text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-bold">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
