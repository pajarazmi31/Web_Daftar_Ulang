<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrasiPesertaDidik;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrasiController extends Controller
{
    public function index()
    {
        $registrasi = RegistrasiPesertaDidik::with('pesertaDidik')->latest()->get();
        return view('admin.registrasi.index', compact('registrasi'));
    }

    public function create()
    {
        // Ambil peserta didik yang belum melakukan registrasi agar tidak ganda
        $registeredIds = RegistrasiPesertaDidik::pluck('peserta_didik_id')->toArray();
        $pesertaList = PesertaDidik::whereNotIn('id', $registeredIds)->get();

        return view('admin.registrasi.create', compact('pesertaList'));
    }

    protected function getValidationRules($isUpdate = false)
    {
        $fileRule = $isUpdate ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';

        return [
            'peserta_didik_id'             => $isUpdate ? 'required' : 'required|unique:registrasi_peserta_didik,peserta_didik_id',
            'kompetensi_keahlian'          => 'required|in:Teknik Otomotif,Teknik Jaringan Komputer dan Telekomunikasi,Pengembangan Perangkat Lunak dan Gim,Desain Pemodelan dan Informasi Bangunan,Manajemen Perkantoran dan Layanan Bisnis,Akuntansi dan Keuangan Lembaga,Seni Pertunjukan',
            'jenis_pendaftaran'            => 'required|in:Siswa Baru,Pindahan,Kembali Bersekolah',
            'sekolah_asal'                 => 'nullable|string|max:255',
            'pernah_paud'                  => 'required|in:Ya,Tidak',
            'hobi'                         => 'nullable|string|max:255',
            'cita_cita'                    => 'nullable|string|max:255',
            'status_registrasi'            => 'required|in:Draft,Menunggu Verifikasi,Diterima,Ditolak',
            'kk'                           => $fileRule,
            'ktp_ortu'                     => $fileRule,
            'akta_kelahiran'               => $fileRule,
            'surat_keterangan_lulus'       => $fileRule,
            'kartu_kesejahteraan'          => $fileRule,
            'sptjm'                        => $fileRule,
            'surat_pernyataan_tata_tertib' => $fileRule,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules(false));

        // Proses Unggah Berkas Dokumen berkas
        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan', 'sptjm', 'surat_pernyataan_tata_tertib'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('berkas', 'public');
            }
        }

        RegistrasiPesertaDidik::create($validated);

        return redirect()->route('registrasi.index')->with('success', 'Data registrasi dan dokumen berkas berhasil disimpan.');
    }

    public function show($id)
{
    // Mengambil data registrasi berserta relasi pesertaDidik-nya
    $registrasi = RegistrasiPesertaDidik::with('pesertaDidik')->findOrFail($id);
    
    return view('admin.registrasi.detail', compact('registrasi'));
}

    public function edit($id)
    {
        $registrasi = RegistrasiPesertaDidik::findOrFail($id);
        $pesertaList = PesertaDidik::all(); // Untuk opsi edit jika diperlukan ganti siswa
        return view('admin.registrasi.edit', compact('registrasi', 'pesertaList'));
    }

    public function update(Request $request, $id)
    {
        $registrasi = RegistrasiPesertaDidik::findOrFail($id);
        $validated = $request->validate($this->getValidationRules(true));

        // Pembaruan File Dokumen Berkas Berkas
        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan', 'sptjm', 'surat_pernyataan_tata_tertib'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus berkas lama jika ada sebelum menimpa berkas baru
                if ($registrasi->$field) {
                    Storage::disk('public')->delete($registrasi->$field);
                }
                $validated[$field] = $request->file($field)->store('berkas', 'public');
            }
        }

        $registrasi->update($validated);

        return redirect()->route('registrasi.index')->with('success', 'Rekam berkas registrasi siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $registrasi = RegistrasiPesertaDidik::findOrFail($id);
        
        // Hapus fisik berkas berkas yang melekat pada database sebelum record dihapus
        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan', 'sptjm', 'surat_pernyataan_tata_tertib'];
        foreach ($fileFields as $field) {
            if ($registrasi->$field) {
                Storage::disk('public')->delete($registrasi->$field);
            }
        }

        $registrasi->delete();
        return redirect()->route('registrasi.index')->with('success', 'Data registrasi berhasil dihapus dari sistem.');
    }
}