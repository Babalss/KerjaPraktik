@extends('layouts.auth')


@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Login</h2>


<form action="/login" method="POST">
    @csrf
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded" required>
    </div>
    <button class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Login</button>
    <div class="text-center mt-3">
        <a href="/register" class="text-blue-600">Daftar</a> |
        <a href="/forgot-password" class="text-blue-600">Lupa Password?</a>
    </div>
</form>
@endsection