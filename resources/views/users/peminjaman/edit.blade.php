@extends('layouts.app')

@section('title', 'Edit Peminjaman • Tralla')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-4">

    <div class="w-100 rounded-3 bg-white p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Edit Peminjaman</h4>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size:0.75rem">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('peminjaman.update', $borrow->id) }}"
              method="POST"
              enctype="multipart/form-data"
              style="font-size:0.75rem">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       class="form-control form-control-sm"
                       value="{{ old('nama_barang', $borrow->nama_barang) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Divisi</label>
                <input type="text"
                       name="divisi"
                       class="form-control form-control-sm"
                       value="{{ old('divisi', $borrow->divisi) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Barang</label>
                <input type="file"
                       name="foto_barang"
                       class="form-control form-control-sm">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto
                </small>

                <div class="mt-2">
                    <img src="{{ asset('storage/' . $borrow->foto_barang) }}"
                         width="120"
                         class="rounded border">
                </div>
            </div>

            {{-- Action --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('peminjaman.index') }}"
                   class="btn btn-outline-secondary btn-sm px-3">
                    Batal
                </a>
                <button type="submit"
                        class="btn btn-primary btn-sm px-4">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
