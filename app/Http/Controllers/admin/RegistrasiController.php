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

        // 2. Query Utama dengan Eager Loading + Filter Dinamis
        $registrasis = RegistrasiPesertaDidik::with('pesertaDidik')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('sekolah_asal', 'like', "%{$search}%")
                        ->orWhereHas('pesertaDidik', function ($pesertaQuery) use ($search) {
                            $pesertaQuery->where('nama_lengkap', 'like', "%{$search}%")
                                ->orWhere('nisn', 'like', "%{$search}%")
                                ->orWhere('kompetensi_keahlian', 'like', "%{$search}%");
                        });
                });
            })
            ->when($jurusan, function ($query, $jurusan) {
                return $query->whereHas('pesertaDidik', function ($pesertaQuery) use ($jurusan) {
                    $pesertaQuery->where('kompetensi_keahlian', $jurusan);
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status_registrasi', $status);
            })
            ->latest()
            ->paginate(10);

        // 3. Hitung data untuk Card Statistik
        $totalRegistrasi = RegistrasiPesertaDidik::count();
        $countPending   = RegistrasiPesertaDidik::where('status_registrasi', 'Menunggu Verifikasi')->count();
        $countDisetujui = RegistrasiPesertaDidik::where('status_registrasi', 'Diterima')->count();
        $countDitolak   = RegistrasiPesertaDidik::where('status_registrasi', 'Ditolak')->count();

        return view('admin.registrasi.index', compact(
            'registrasis',
            'totalRegistrasi',
            'countPending',
            'countDisetujui',
            'countDitolak'
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
