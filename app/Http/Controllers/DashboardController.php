<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesertaDidik;
use App\Models\RegistrasiPesertaDidik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function landingpage()
    {
        return view('landingpage');
    }

    public function admin()
    {
        $user = Auth::user();

        $totalPeserta = PesertaDidik::count();

        $totalOperator = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'operator');
        })->count();

        $pesertaTerbaru = PesertaDidik::with('registrasi')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'totalPeserta',
            'totalOperator',
            'pesertaTerbaru'
        ));
    }

    public function kepsek()
    {
        $user = Auth::user();

        // 1. Executive Summary Cards
        $totalPeserta = PesertaDidik::count();

        // Asumsi total registrasi adalah peserta yang statusnya sudah 'diterima' atau 'registrasi'
        // Sesuaikan string 'diterima' dengan nilai status di database Anda
        $totalRegistrasi = RegistrasiPesertaDidik::count();

        // 2. Laporan Keterisian Kuota per Kompetensi Keahlian (Jurusan)
        $rekapJurusan = RegistrasiPesertaDidik::select('kompetensi_keahlian', DB::raw('count(*) as total'))
            ->groupBy('kompetensi_keahlian')
            ->get();

        // 3. Proporsi Gender
        // Sesuaikan string 'L' / 'P' atau 'Laki-laki' / 'Perempuan' dengan database Anda
        $pria = PesertaDidik::whereIn('jenis_kelamin', ['L', 'Laki-laki'])->count();
        $wanita = PesertaDidik::whereIn('jenis_kelamin', ['P', 'Perempuan'])->count();

        // 4. Analisis Profil Afirmasi & Beasiswa
        // Kolom punya_kip & penerima_kip disesuaikan dengan skema migration Anda
        $punyaKipBelumMenerima = PesertaDidik::where('punya_kip', true)
            ->where(function ($query) {
                $query->where('penerima_kip', false)
                    ->orWhereNull('penerima_kip');
            })->count();

        // Menghitung siswa jalur prestasi atau mendapatkan beasiswa
        $totalBeasiswa = PesertaDidik::where('jenis_beasiswa', 'prestasi')->count();

        // 5. Top 3 Asal Sekolah Terbanyak (Feeder)
        $topSekolahAsal = RegistrasiPesertaDidik::select('sekolah_asal', DB::raw('count(*) as total'))
            ->whereNotNull('sekolah_asal')
            ->groupBy('sekolah_asal')
            ->orderBy('total', 'desc')
            ->take(3)
            ->get();

        return view('kepsek.dashboard', compact(
            'user',
            'totalPeserta',
            'totalRegistrasi',
            'rekapJurusan',
            'pria',
            'wanita',
            'punyaKipBelumMenerima',
            'totalBeasiswa',
            'topSekolahAsal'
        ));
    }

    /**
     * Dashboard untuk Operator Sistem
     */
    public function operator()
    {
        $user = Auth::user();

        $totalPeserta = PesertaDidik::count();

        $totalOperator = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'operator');
        })->count();

        $pesertaTerbaru = PesertaDidik::with('registrasi')
            ->latest()
            ->take(5)
            ->get();

        $countPending   = RegistrasiPesertaDidik::where('status_registrasi', 'Menunggu Verifikasi')->count();
        $countDisetujui = RegistrasiPesertaDidik::where('status_registrasi', 'Diterima')->count();
        $countDitolak   = RegistrasiPesertaDidik::where('status_registrasi', 'Ditolak')->count();


        return view('operator.dashboard', compact(
            'user',
            'totalPeserta',
            'totalOperator',
            'pesertaTerbaru',
            'countPending',
            'countDisetujui',
            'countDitolak'
        ));
    }
}
