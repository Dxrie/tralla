@extends('layouts.app')

@section('title', 'Divisi • Tralla')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Whoops!</strong> Ada masalah dengan input anda:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="h4 text-gray-800 mb-0">Manajemen Divisi</h2>
            </div>
        </div>

        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('divisi.store') }}" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-12 col-md-6">
                        <label class="form-label mb-1">Nama divisi</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                            placeholder="Contoh: HR, Finance, Engineering">
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-1"></i> Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th>Nama</th>
                                <th class="text-end" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($divisions as $division)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $division->name }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('divisi.destroy', $division) }}"
                                            onsubmit="return confirm('Hapus divisi ini?')"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada divisi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

