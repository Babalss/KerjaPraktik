@extends('layouts.auth')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Atur Ulang Password</h2>

<form action="{{ route('password.update') }}" method="POST">
  @csrf

  {{-- Token dari URL /reset-password/{token} --}}
  <input type="hidden" name="token" value="{{ $token ?? '' }}">

  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}" required>
  </div>

  <div class="mb-3">
    <label>Password Baru</label>
    <input type="password" name="password" class="w-full border p-2 rounded" required>
  </div>

  <div class="mb-3">
    <label>Konfirmasi Password Baru</label>
    <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
  </div>

  <button class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
    Simpan Password Baru
  </button>

  <div class="text-center mt-3">
    <a href="/login" class="text-blue-600">Kembali ke Login</a>
  </div>
</form>
@endsection
