<?php

namespace App\Http\Controllers\kepsek;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Exports\DataSiswaExport; // Import Class Export
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // Import Facade Excel

class LaporanController extends Controller
{
    // ... (method admin, kepalaSekolah, atau operator yang sudah ada sebelumnya) ...

    /**
     * Halaman Laporan Detail Gabungan untuk Kepala Sekolah
     */
    public function laporanKepalaSekolah(Request $request)
    {
        $user = Auth::user();

        // Ambil daftar kompetensi keahlian unik untuk pilihan filter di view
        $daftarJurusan = DB::table('registrasi_peserta_didik')
            ->whereNotNull('kompetensi_keahlian')
            ->distinct()
            ->pluck('kompetensi_keahlian');

        // Query Utama: Menggabungkan data peserta didik dengan registrasi
        $query = PesertaDidik::query()
            ->join('registrasi_peserta_didik', 'peserta_didik.id', '=', 'registrasi_peserta_didik.peserta_didik_id')
            ->select(
                'peserta_didik.*', 
                'registrasi_peserta_didik.kompetensi_keahlian', 
                'registrasi_peserta_didik.jenis_pendaftaran', 
                'registrasi_peserta_didik.sekolah_asal', 
                'registrasi_peserta_didik.status_registrasi'
            );

        // Terapkan filter Kompetensi Keahlian jika dipilih oleh Kepsek
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('registrasi_peserta_didik.kompetensi_keahlian', $request->jurusan);
        }

        // Ambil data dengan pagination agar performa load halaman tetap ringan
        $laporanData = $query->latest('peserta_didik.created_at')->paginate(15)->withQueryString();

        return view('kepsek.laporan.laporan', compact('user', 'laporanData', 'daftarJurusan'));
    }

    /**
     * Aksi Export Data ke Excel
     */
    public function exportExcel(Request $request)
    {
        $jurusanFilter = $request->input('jurusan');
        $namaFile = 'Laporan_Detail_Peserta_Didik_' . ($jurusanFilter ? str_replace(' ', '_', $jurusanFilter) : 'Semua_Jurusan') . '_' . date('dYmHis') . '.xlsx';

        return Excel::download(new DataSiswaExport($jurusanFilter), $namaFile);
    }

    public function detail($id)
    {
        $user = Auth::user();

        // Cari data peserta didik, satukan dengan tabel registrasi_peserta_didik menggunakan inner/left join
        $siswa = PesertaDidik::query()
            ->leftJoin('registrasi_peserta_didik', 'peserta_didik.id', '=', 'registrasi_peserta_didik.peserta_didik_id')
            ->select('peserta_didik.*', 'registrasi_peserta_didik.*', 'peserta_didik.id as id_utama') // bedakan ID utama pendaftar
            ->where('peserta_didik.id', $id)
            ->firstOrFail();

        return view('kepsek.laporan.detail', compact('user', 'siswa'));
    }
}