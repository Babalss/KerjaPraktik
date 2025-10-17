<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;


class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }


    public function index()
    {
        return view('admin.dashboard', [
            'user' => Auth::user()
        ]);
    }
}
