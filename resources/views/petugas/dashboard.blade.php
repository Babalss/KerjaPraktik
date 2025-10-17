@extends('layouts.auth')


@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Dashboard Petugas</h2>
<p class="text-center mb-4">Selamat datang, {{ $user->name }} (Role: Petugas)</p>


<div class="text-center">
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-link" style="padding:0; border:none; background:none;">
        Logout
    </button>
</form>


</div>
@endsection
