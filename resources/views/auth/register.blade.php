@extends('layouts.app')

@section('title', 'Signup - Todana')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Signup</h2>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror" id="password" name="password" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors mb-4">Daftar</button>
            </form>

            <div class="text-center">
                <p class="text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Login di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
