@extends('layouts.app')

@section('title', 'Profile - Todana')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">Profile Saya</h1>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h5 class="text-xl font-semibold mb-6">Update Profile</h5>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6 border-gray-300">

                <h5 class="text-lg font-semibold mb-4">Ganti Password (Optional)</h5>

                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror" id="current_password" name="current_password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror" id="password" name="password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="password_confirmation" name="password_confirmation">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection
