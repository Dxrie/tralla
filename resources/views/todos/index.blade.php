@extends('layouts.app')

@section('title', 'Daftar To-Do • Tralla')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-4">
    <div class="w-100 rounded-3 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-center mb-0">To-Do List</h4>
            <a href="{{ route('todo.create') }}" class="btn btn-primary py-1.5" style="font-size:0.75rem">+ Tambah To-Do</a>
        </div>

        <table class="table table-hover mb-0" style="font-size:0.75rem">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Judul</th>
                    <th style="width: 20%;">Deskripsi</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 15%;">Tanggal Selesai</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($todos as $todo)  
                    <tr class="align-middle">
                        <td style="width: 5%;">{{ $loop->iteration }}</td>
                        <td style="width: 15%;">{{ $todo->title }}</td>
                        <td style="width: 20%;">{{ $todo->description }}</td>
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
@endsection

