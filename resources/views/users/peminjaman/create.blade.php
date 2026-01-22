@extends('layouts.app')

@section('title', 'Tambah Peminjaman • Tralla')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-4">

    <div class="w-100 rounded-3 bg-white p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Tambah Peminjaman Barang</h4>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size:0.75rem">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('peminjaman.store') }}"
              method="POST"
              enctype="multipart/form-data"
              style="font-size:0.75rem">
            @csrf

            {{-- Nama Barang --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       class="form-control form-control-sm"
                       value="{{ old('nama_barang') }}"
                       placeholder="Masukkan nama barang">
            </div>

            {{-- Divisi --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Divisi</label>
                <select name="divisi" class="form-select form-select-sm">
                    <option value="">-- Pilih Divisi --</option>
                    <option value="KP" {{ old('divisi') == 'KP' ? 'selected' : '' }}>KP</option>
                    <option value="MBKM" {{ old('divisi') == 'MBKM' ? 'selected' : '' }}>MBKM</option>
                    <option value="Manajemen" {{ old('divisi') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                    <option value="Magang PKL" {{ old('divisi') == 'Magang PKL' ? 'selected' : '' }}>Magang PKL</option>
                </select>
            </div>

            {{-- Foto Barang --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Foto Barang</label>
                <input type="file"
                       name="foto_barang"
                       class="form-control form-control-sm"
                       accept="image/*">
            </div>

            {{-- Action --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('peminjaman.index') }}"
                   class="btn btn-outline-secondary btn-sm px-3">
                    Batal
                </a>
                <button type="submit"
                        class="btn btn-primary btn-sm px-4">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
