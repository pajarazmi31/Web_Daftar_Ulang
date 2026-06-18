<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesertaDidik; // Sesuaikan dengan nama Model Data Peserta Anda
use App\Models\RegistrasiPesertaDidik;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    // Tambahkan fungsi ini di dalam SiswaDashboardController

    public function index()
    {
        $user = Auth::user();

        // Ambil data peserta milik siswa yang login
        $peserta = PesertaDidik::where('user_id', $user->id)->first();

        // Ambil record registrasi untuk mengecek status pendaftaran siswa
        // Asumsi: Anda memiliki model/tabel Registrasi
        $registrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->first();

        $sudahRegistrasi = $registrasi ? true : false;
        $statusRegistrasi = $registrasi ? $registrasi->status : 'belum'; // status bisa: pending, disetujui, ditolak

        return view('siswa.dashboard', compact('peserta', 'sudahRegistrasi', 'statusRegistrasi'));
    }

    // 1. Menampilkan data diri siswa yang sedang login
    public function dataDiri()
    {
        // Mencari data peserta didik yang terikat dengan user_id akun yang sedang login
        $peserta = PesertaDidik::where('user_id', Auth::id())->first();

        return view('siswa.data-diri', compact('peserta'));
    }

    // 2. Proses update data diri jika ada kesalahan input
    public function updateDataDiri(Request $request)
    {
        $peserta = PesertaDidik::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|numeric|unique:peserta_didiks,nisn,' . $peserta->id,
            // Tambahkan validasi lain sesuai kebutuhan field database Anda
        ]);

        $peserta->update([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            // update field lainnya...
        ]);

        return redirect()->route('siswa.data-diri')->with('success', 'Data diri berhasil diperbarui!');
    }

    // 3. Halaman registrasi mandiri oleh siswa
    public function registrasi()
    {
        $user = Auth::user();
        $peserta = PesertaDidik::where('user_id', $user->id)->first();

        // Cek apakah siswa sudah terdaftar sebelumnya
        $sudahRegistrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->exists();

        return view('siswa.registrasi', compact('peserta', 'sudahRegistrasi'));
    }

    // 4. Proses simpan registrasi mandiri
    public function storeRegistrasi(Request $request)
    {
        // Menggunakan validasi ketat sesuai struktur tabel Anda
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'nisn'           => 'required|string|max:10|unique:peserta_didik,nisn', // NISN wajib untuk registrasi mandiri
            'nik'            => 'required|string|max:16',
            'no_kk'          => 'required|string|max:16',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'agama'          => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Khonghucu,Kepercayaan Kepada Tuhan YME',
            'alamat'         => 'required|string',
            'desa_kelurahan' => 'required|string|max:255',
            'kecamatan'      => 'required|string|max:255',
        ]);

        // Set attribute otomatis
        $validated['user_id']           = Auth::id(); // Mengikat langsung ke akun siswa yang sedang login
        $validated['created_by']        = Auth::id();
        $validated['nomor_pendaftaran'] = 'REG-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));

        // Simpan ke tabel peserta didik
        PesertaDidik::create($validated);

        // Jika Anda menggunakan tabel perantara 'registrasi' untuk status approval:
        RegistrasiPesertaDidik::create([
            'user_id'        => Auth::id(),
            'status'         => 'pending',
            'tanggal_daftar' => now(),
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi mandiri berhasil! Data Anda sedang ditinjau.');
    }
}
