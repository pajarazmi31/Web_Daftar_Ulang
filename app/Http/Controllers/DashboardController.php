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

        $totalRegistrasi = RegistrasiPesertaDidik::all()->count();

        $pesertaTerbaru = PesertaDidik::with('registrasi')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'totalPeserta',
            'totalOperator',
            'pesertaTerbaru',
            'totalRegistrasi'
        ));
    }

    public function kepsek()
    {
        $user = Auth::user();

        // 1. Executive Summary Cards
        $totalPeserta = PesertaDidik::count();
        $totalRegistrasi = RegistrasiPesertaDidik::count();

        // 2. Laporan Keterisian Kuota per Kompetensi Keahlian (Jurusan)
        $rekapJurusan = RegistrasiPesertaDidik::select('kompetensi_keahlian', DB::raw('count(*) as total'))
            ->groupBy('kompetensi_keahlian')
            ->get();

        // 3. Proporsi Gender
        $pria = PesertaDidik::whereIn('jenis_kelamin', ['L', 'Laki-laki'])->count();
        $wanita = PesertaDidik::whereIn('jenis_kelamin', ['P', 'Perempuan'])->count();

        // 4. Analisis Profil Afirmasi & Beasiswa (PERBAIKAN DI SINI)
        $punyaKipBelumMenerima = PesertaDidik::where('punya_kip', true)
            ->where(function ($query) {
                $query->where('penerima_kip', false)
                    ->orWhereNull('penerima_kip');
            })->count();

        // Ambil data total masing-masing sesuai string ENUM di Migration Anda
        $beasiswaBerprestasi = PesertaDidik::where('jenis_beasiswa', 'Anak Berprestasi')->count();
        $beasiswaMiskin       = PesertaDidik::where('jenis_beasiswa', 'Anak Miskin')->count();
        $beasiswaPendidikan   = PesertaDidik::where('jenis_beasiswa', 'Pendidikan')->count();
        $beasiswaUnggulan     = PesertaDidik::where('jenis_beasiswa', 'Unggulan')->count();

        // 5. Top 5 Asal Sekolah Terbanyak (Feeder)
        $topSekolahAsal = RegistrasiPesertaDidik::select('sekolah_asal', DB::raw('count(*) as total'))
            ->whereNotNull('sekolah_asal')
            ->groupBy('sekolah_asal')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Pastikan semua variabel baru dimasukkan ke dalam compact()
        return view('kepsek.dashboard', compact(
            'user',
            'totalPeserta',
            'totalRegistrasi',
            'rekapJurusan',
            'pria',
            'wanita',
            'punyaKipBelumMenerima',
            'beasiswaBerprestasi',
            'beasiswaMiskin',
            'beasiswaPendidikan',
            'beasiswaUnggulan',
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
