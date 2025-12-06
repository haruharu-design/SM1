@extends('layouts.app')

@section('title', 'Contact - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Container form -->
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">Hubungi Kami</h1>

        <!-- Card informasi kontak -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h5 class="text-xl font-bold mb-4">Informasi Kontak</h5>
            <p class="text-gray-700 mb-2"><strong>Email:</strong> SinarMentari@gamil.com</p>
            <p class="text-gray-700 mb-2"><strong>Telepon:</strong> +62-815-2844-2245</p>
            <p class="text-gray-700"><strong>Alamat:</strong> Jl. Putri Candramidi, deretan Masjid Mujahidin, Kota Baru Pontianak</p>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d514.6903829570713!2d109.34118312084298!3d-0.06656940636237706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d594fecd4fc1b%3A0xaeb6ee94805b6012!2sKopi%20Kenangan%20-%20Reformasi%20Pontianak!5e0!3m2!1sen!2sid!4v1765026486520!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- Card form pesan -->
        <div class="bg-white rounded-lg shadow p-6">
            <h5 class="text-xl font-bold mb-6">Kirim Pesan</h5>
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <!-- Input nama -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border rounded @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required>
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
                <!-- Textarea pesan -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Pesan</label>
                    <textarea class="w-full px-4 py-2 border rounded @error('message') border-red-500 @enderror" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Tombol submit -->
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
