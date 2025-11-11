@extends('layouts.auth')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Lupa Password</h2>

<form action="{{ route('password.email') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}" required autofocus>
  </div>

  <button class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
    Kirim Link Reset Password
  </button>

  <div class="text-center mt-3">
    <a href="/login" class="text-blue-600">Kembali ke Login</a> |
    <a href="/register" class="text-blue-600">Daftar</a>
  </div>
</form>
@endsection
