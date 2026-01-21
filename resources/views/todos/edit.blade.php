@extends('layouts.app')

@section('title', 'Edit To-Do • Tralla')

@section('content')
<div class="w-100 h-100 d-flex flex-column gap-4">

    <div class="w-100 rounded-3 bg-white p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Edit To-Do</h4>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size:0.75rem">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('todo.update', $todo->id) }}"
              method="POST"
              style="font-size:0.75rem">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:0.75rem">Judul</label>
                <input type="text"
                       name="title"
                       class="form-control form-control-sm"
                       value="{{ old('title', $todo->title) }}"
                       placeholder="Masukkan judul to-do"
                       style="font-size:0.75rem">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:0.75rem">Deskripsi</label>
                <input type="text"
                       name="description"
                       class="form-control form-control-sm"
                       value="{{ old('description', $todo->description) }}"
                       placeholder="Masukkan deskripsi"
                       style="font-size:0.75rem">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:0.75rem">Status</label>
                <select name="status" class="form-select form-select-sm" style="font-size:0.75rem">
                    <option value="to-do" {{ old('status', $todo->status) == 'to-do' ? 'selected' : '' }}>To-Do</option>
                    <option value="on progress" {{ old('status', $todo->status) == 'on progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="hold" {{ old('status', $todo->status) == 'hold' ? 'selected' : '' }}>Hold</option>
                    <option value="done" {{ old('status', $todo->status) == 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:0.75rem">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       class="form-control form-control-sm"
                       value="{{ old('tanggal', $todo->tanggal) }}"
                       style="font-size:0.75rem">
            </div>

            {{-- Action --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('todo.index') }}"
                   class="btn btn-outline-secondary btn-sm px-3"
                   style="font-size:0.75rem">
                    Batal
                </a>
                <button type="submit"
                        class="btn btn-primary btn-sm px-4"
                        style="font-size:0.75rem">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
