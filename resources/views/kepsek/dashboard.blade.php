@extends('layouts.dashboard')

@section('title','Dashboard Kepala Sekolah')

@section('header_title')
Dashboard Kepala Sekolah
@endsection

@section('header_subtitle')
Monitoring laporan daftar ulang peserta didik
@endsection

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-slate-500">
            Total Peserta
        </p>

        <h3 class="text-4xl font-bold mt-3">
            {{ $totalPeserta ?? 0 }}
        </h3>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-slate-500">
            Registrasi Lengkap
        </p>

        <h3 class="text-4xl font-bold mt-3 text-green-600">
            {{ $lengkap ?? 0 }}
        </h3>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-slate-500">
            Belum Lengkap
        </p>

        <h3 class="text-4xl font-bold mt-3 text-red-600">
            {{ $belum ?? 0 }}
        </h3>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-slate-500">
            Dokumen Terverifikasi
        </p>

        <h3 class="text-4xl font-bold mt-3 text-blue-600">
            {{ $verifikasi ?? 0 }}
        </h3>
    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm mt-6 p-6">

    <h3 class="font-semibold mb-4">
        Ringkasan Laporan
    </h3>

    <table class="w-full">

        <thead>
            <tr class="border-b">
                <th class="text-left py-3">
                    Kategori
                </th>

                <th class="text-left py-3">
                    Jumlah
                </th>
            </tr>
        </thead>

        <tbody>

            <tr class="border-b">
                <td class="py-3">
                    Peserta Didik
                </td>

                <td>
                    {{ $totalPeserta ?? 0 }}
                </td>
            </tr>

            <tr class="border-b">
                <td class="py-3">
                    Registrasi Lengkap
                </td>

                <td>
                    {{ $lengkap ?? 0 }}
                </td>
            </tr>

            <tr>
                <td class="py-3">
                    Registrasi Belum Lengkap
                </td>

                <td>
                    {{ $belum ?? 0 }}
                </td>
            </tr>

        </tbody>

    </table>

</div>

@endsection