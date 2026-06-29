<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrasiPesertaDidik;
use App\Models\PesertaDidik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegistrasiController extends Controller
{
public function index(Request $request)
{
    // 1. Ambil input pencarian dan filter
    $search  = $request->input('search');
    $jurusan = $request->input('jurusan');
    $status  = $request->input('status');

    // 2. Query Utama DIBALIK dari model PesertaDidik agar siswa yang belum daftar bisa ditarik
    $query = PesertaDidik::with('registrasi');

    // Filter Berdasarkan Pencarian Teks
    $query->when($search, function ($q) use ($search) {
        return $q->where(function ($inner) use ($search) {
            $inner->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('kompetensi_keahlian', 'like', "%{$search}%")
                  ->orWhereHas('registrasi', function ($regQuery) use ($search) {
                      $regQuery->where('sekolah_asal', 'like', "%{$search}%");
                  });
        });
    });

    // Filter Berdasarkan Jurusan
    $query->when($jurusan, function ($q) use ($jurusan) {
        return $q->where('kompetensi_keahlian', $jurusan);
    });

    // Filter Berdasarkan Status (Kunci Jawaban Tantangan Ini)
    $query->when($status, function ($q) use ($status) {
        if ($status === 'Belum Registrasi') {
            return $q->doesntHave('registrasi'); // Menampilkan yang tidak punya data registrasi
        } else {
            return $q->whereHas('registrasi', function ($regQuery) use ($status) {
                $regQuery->where('status_registrasi', $status);
            });
        }
    });

    // Jalankan pagination
    $paginatedSiswa = $query->latest()->paginate(10)->withQueryString();

    // Pemetaan (Mapping) agar strukturnya tetap sama seperti format RegistrasiPesertaDidik di Blade lamamu
    $registrasis = $paginatedSiswa->setCollection(
        $paginatedSiswa->getCollection()->map(function ($siswa) {
            // Jika siswa sudah registrasi, ambil data registrasinya lalu tempelkan relasi siswa ke dalamnya
            if ($siswa->registrasi) {
                $reg = $siswa->registrasi;
                $reg->setRelation('pesertadidik', $siswa);
                return $reg;
            }
            
            // Jika BELUM registrasi, buat objek tiruan baru di memori agar struktur di Blade tidak error/crash
            $newReg = new \App\Models\RegistrasiPesertaDidik();
            $newReg->status_registrasi = 'Belum Registrasi';
            $newReg->setRelation('pesertadidik', $siswa);
            return $newReg;
        })
    );

    // 3. Hitung data untuk Card Statistik (Query ini tetap dari RegistrasiPesertaDidik)
    $totalRegistrasi = RegistrasiPesertaDidik::count();
    $countPending   = RegistrasiPesertaDidik::where('status_registrasi', 'Menunggu Verifikasi')->count();
    $countDisetujui = RegistrasiPesertaDidik::where('status_registrasi', 'Diterima')->count();
    $countDitolak   = RegistrasiPesertaDidik::where('status_registrasi', 'Ditolak')->count();
    $countBelumRegistrasi = PesertaDidik::doesntHave('registrasi')->count();

    return view('admin.registrasi.index', compact(
        'registrasis',
        'totalRegistrasi',
        'countPending',
        'countDisetujui',
        'countDitolak',
        'countBelumRegistrasi'
    ));
}

    public function create()
    {
        $registeredIds = RegistrasiPesertaDidik::pluck('peserta_didik_id')->toArray();
        $pesertaList = PesertaDidik::whereNotIn('id', $registeredIds)->get();

        return view('admin.registrasi.create', compact('pesertaList'));
    }

    protected function getValidationRules($isUpdate = false)
    {
        $optionalFileRule = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';

        return [
            'peserta_didik_id'             => $isUpdate ? 'required' : 'required|unique:registrasi_peserta_didik,peserta_didik_id',
            'jenis_pendaftaran'            => 'required|string',
            'sekolah_asal'                 => 'nullable|string|max:255',
            'pernah_paud'                  => 'required|in:Ya,Tidak',
            'hobi'                         => 'nullable|string|max:255',
            'cita_cita'                    => 'nullable|string|max:255',
            'status_registrasi'            => 'required|in:Menunggu Verifikasi,Diterima,Ditolak',

            'kk'                           => $optionalFileRule,
            'ktp_ortu'                     => $optionalFileRule,
            'akta_kelahiran'               => $optionalFileRule,
            'surat_keterangan_lulus'       => $optionalFileRule,
            'kartu_kesejahteraan'          => $optionalFileRule,
        ];
    }

    public function store(Request $request)
    {
        $customMessages = [
            'max' => 'Ukuran file :attribute melebihi 2MB. Silakan kompres terlebih dahulu sebelum diunggah.',
            'mimes' => 'Format file :attribute harus berupa PDF, JPG, JPEG, atau PNG.'
        ];

        $validated = $request->validate($this->getValidationRules(false), $customMessages);

        $peserta = PesertaDidik::findOrFail($request->peserta_didik_id);
        $user = User::where('email', $peserta->nisn)->firstOrFail();
        $validated['user_id'] = $user->id;

        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                // Langsung simpan file asli tanpa membedakan format gambar atau PDF
                $validated[$field] = $file->store('berkas', 'public');
            }
        }

        RegistrasiPesertaDidik::create($validated);

        return redirect()->route('registrasi.index')->with('success', 'Data registrasi berhasil disimpan dan akun siswa telah disinkronkan.');
    }

    public function show($id)
    {
        $registrasi = RegistrasiPesertaDidik::with('pesertaDidik')->findOrFail($id);
        return view('admin.registrasi.detail', compact('registrasi'));
    }

    public function edit($id)
    {
        $registrasi = RegistrasiPesertaDidik::findOrFail($id);
        $pesertaList = PesertaDidik::all();
        return view('admin.registrasi.edit', compact('registrasi', 'pesertaList'));
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'max' => 'Ukuran file :attribute melebihi 2MB. Silakan kompres terlebih dahulu sebelum diunggah.',
            'mimes' => 'Format file :attribute harus berupa PDF, JPG, JPEG, atau PNG.'
        ];

        // Mengubah `:attribute` menjadi nama dokumen yang rapi di mata user
        $customAttributes = [
            'kk' => 'Kartu Keluarga (KK)',
            'ktp_ortu' => 'KTP Orang Tua',
            'akta_kelahiran' => 'Akta Kelahiran',
            'surat_keterangan_lulus' => 'Surat Keterangan Lulus (SKL)',
            'kartu_kesejahteraan' => 'Kartu Kesejahteraan',
        ];

        $registrasi = RegistrasiPesertaDidik::findOrFail($id);

        // Masukkan $customMessages di argumen ke-2, dan $customAttributes di argumen ke-3
        $validated = $request->validate(
            $this->getValidationRules(true),
            $customMessages,
            $customAttributes
        );

        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($registrasi->$field) {
                    Storage::disk('public')->delete($registrasi->$field);
                }

                $file = $request->file($field);
                $validated[$field] = $file->store('berkas', 'public');
            }
        }

        $registrasi->update($validated);

        return redirect()->route('registrasi.index')->with('success', 'Rekam berkas registrasi siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $registrasi = RegistrasiPesertaDidik::findOrFail($id);

        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan'];
        foreach ($fileFields as $field) {
            if ($registrasi->$field) {
                Storage::disk('public')->delete($registrasi->$field);
            }
        }

        $registrasi->delete();
        return redirect()->route('registrasi.index')->with('success', 'Data registrasi berhasil dihapus dari sistem.');
    }
}
