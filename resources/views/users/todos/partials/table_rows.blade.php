@forelse ($todos as $todo)
    <tr class="align-middle text-center" data-id="{{ $todo->id }}">
        <td style="width: 5%;">{{ $todo->id }}</td>
        <td style="width: 15%;" class="text-start">
            {{ $todo->title }}
            @if($todo->subtasks->count() > 0)
                <button class="btn btn-sm btn-outline-secondary py-0 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#subtasks-{{ $todo->id }}" aria-expanded="false" aria-controls="subtasks-{{ $todo->id }}">
                    <i class="bi bi-chevron-down"></i>
                </button>
            @endif
        </td>
        <td style="width: 20%;" class="text-start">{{ $todo->description }}</td>
        <td style="width: 15%;">{{ $todo->status }}</td>
        <td style="width: 15%;">{{ $todo->start_date }}</td>
        <td style="width: 15%;">
            @if ($todo->finish_date)
                {{ \Carbon\Carbon::parse($todo->finish_date)->format('Y-m-d') }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td class="text-nowrap" style="width: 15%;">
            <button
                class="btn btn-outline-primary btn-sm editTodoBtn"
                data-id="{{ $todo->id }}"
                data-title="{{ $todo->title }}"
                data-description="{{ $todo->description }}"
                data-status="{{ $todo->status }}"
                data-start_date="{{ $todo->start_date }}"
                data-finish_date="{{ $todo->finish_date }}"
                data-subtasks='@json($todo->subtasks->pluck("name"))'
                data-bs-toggle="modal"
                data-bs-target="#todoModal"
            >
                <i class="bi bi-pencil-square"></i>
            </button>

            <button type="button"
                    class="btn btn-outline-danger btn-sm px-2 py-1 deleteTodoBtn"
                    data-id="{{ $todo->id }}"
                    title="Hapus">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
    @if($todo->subtasks->count() > 0)
    <tr>
        <td colspan="7" class="p-0">
            <div class="collapse" id="subtasks-{{ $todo->id }}">
                <div class="p-3 bg-light">
                    <h6 class="mb-3">Subtasks:</h6>
                    <ul class="list-group">
                        @foreach($todo->subtasks as $subtask)
                        <li class="list-group-item d-flex align-items-center">
                            <input class="form-check-input me-2 subtask-checkbox" type="checkbox" data-subtask-id="{{ $subtask->id }}" {{ $subtask->is_done ? 'checked' : '' }}>
                            <span class="{{ $subtask->is_done ? 'text-decoration-line-through text-muted' : '' }}">{{ $subtask->name }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </td>
    </tr>
    @endif
@empty
    <tr class="text-center">
        <td colspan="7">Belum ada data</td>
    </tr>
@endforelse
