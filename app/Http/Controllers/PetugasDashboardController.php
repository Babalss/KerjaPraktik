<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;


class PetugasDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Petugas']);
    }


    public function index()
    {
        return view('petugas.dashboard', [
            'user' => Auth::user()
        ]);
    }
}
