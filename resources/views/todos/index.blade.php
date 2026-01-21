@extends('layouts.app')

@section('title', 'Daftar To-Do • Tralla')

@section('content')
@if (session('success'))
    <div class="alert alert-success py-2" style="font-size:0.75rem">
        {{ session('success') }}
    </div>
@endif



<div class="w-100 h-100 d-flex flex-column gap-4">
    <div class="w-100 rounded-3 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-center mb-0">To-Do List</h3>
            <a href="{{ route('todo.create') }}" class="btn btn-primary py-1.5" style="font-size:0.75rem">+ Tambah To-Do</a>
        </div>
        
        <div class="d-flex gap-2 mb-3" style="font-size:0.75rem">
            <form action="{{ route('todo.index') }}" method="GET" class="d-flex gap-2 w-100">
                <select name="status" class="form-select form-select-sm" style="width: 20%; font-size:0.75rem">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
        
                <select name="bulan" class="form-select form-select-sm" style="width: 20%; font-size:0.75rem">
                    <option value="">Semua Bulan</option>
                    @foreach ($months as $num => $name)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
        
                <select name="tahun" class="form-select form-select-sm" style="width: 20%; font-size:0.75rem">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
        
                <button type="submit" class="btn btn-primary btn-sm" style="font-size:0.75rem">
                    Filter
                </button>
                <a href="{{ route('todo.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size:0.75rem">
                    Reset
                </a>
            </form>
        </div>
        
        <div class="w-100 rounded-3 bg-white p-3 overflow-hidden">
            <table class="table table-hover mb-0" style="font-size:0.75rem;">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;" class="text-start">Judul</th>
                        <th style="width: 20%;" class="text-start">Deskripsi</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 15%;">Tanggal Selesai</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($todos as $todo)  
                        <tr class="align-middle text-center">
                            <td style="width: 5%;">{{ $loop->iteration }}</td>
                            <td style="width: 15%;" class="text-start">{{ $todo->title }}</td>
                            <td style="width: 20%;" class="text-start">{{ $todo->description }}</td>
                            <td style="width: 15%;">{{ $todo->status }}</td>
                            <td style="width: 15%;">{{ $todo->tanggal }}</td>
                            <td style="width: 15%;">
                                @if ($todo->tanggal_selesai)
                                    {{ \Carbon\Carbon::parse($todo->tanggal_selesai)->format('Y-m-d') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-nowrap" style="width: 15%;">
                                <a href="{{ route('todo.edit', $todo->id) }}"
                                class="btn btn-outline-primary btn-sm px-2 py-1 me-1"
                                title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('todo.destroy', $todo->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm px-2 py-1"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="7">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

