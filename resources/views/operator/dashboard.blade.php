@extends('layouts.dashboard')

@section('title','Dashboard Operator')

@section('header_title')
Dashboard Operator
@endsection

@section('header_subtitle')
Kelola data peserta didik dan registrasi
@endsection

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h4 class="text-slate-500 text-sm">
            Total Peserta
        </h4>

        <p class="text-4xl font-bold mt-3">
            {{ $totalPeserta ?? 0 }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h4 class="text-slate-500 text-sm">
            Registrasi Lengkap
        </h4>

        <p class="text-4xl font-bold mt-3 text-green-600">
            {{ $registrasiLengkap ?? 0 }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h4 class="text-slate-500 text-sm">
            Dokumen Pending
        </h4>

        <p class="text-4xl font-bold mt-3 text-yellow-600">
            {{ $pending ?? 0 }}
        </p>
    </div>

</div>

@endsection