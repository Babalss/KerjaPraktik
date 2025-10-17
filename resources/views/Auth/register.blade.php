@extends('layouts.auth')


@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Daftar Akun Baru</h2>


<form action="/register" method="POST">
  @csrf
  <div class="mb-3">
    <label>Nama Lengkap</label>
    <input type="text" name="name" class="w-full border p-2 rounded" required>
  </div>


  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="w-full border p-2 rounded" required>
  </div>


  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="w-full border p-2 rounded" required>
  </div>


  <div class="mb-3">
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
  </div>


  <button class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Daftar</button>


  <div class="text-center mt-3">
    <a href="/login" class="text-blue-600">Sudah punya akun? Login</a>
  </div>
</form>
@endsection
