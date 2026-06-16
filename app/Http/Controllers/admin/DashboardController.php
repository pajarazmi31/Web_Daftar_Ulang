<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\PesertaDidik;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalPeserta = PesertaDidik::count();

        $totalOperator = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'operator');
        })->count();

        $pesertaTerbaru = PesertaDidik::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'totalPeserta',
            'totalOperator',
            'pesertaTerbaru'
        ));
    }
}