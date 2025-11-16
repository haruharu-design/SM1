@extends('layouts.app')

@section('title', 'Contact - Todana')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">Hubungi Kami</h1>
        
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h5 class="text-xl font-semibold mb-4">Informasi Kontak</h5>
            <p class="text-gray-700 mb-2"><strong>Email:</strong> info@todana.com</p>
            <p class="text-gray-700 mb-2"><strong>Telepon:</strong> +62 123 456 789</p>
            <p class="text-gray-700"><strong>Alamat:</strong> Jl. Contoh No. 123, Jakarta</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h5 class="text-xl font-semibold mb-6">Kirim Pesan</h5>
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" required>
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
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
