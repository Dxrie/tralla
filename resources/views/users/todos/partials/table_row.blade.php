<tr class="align-middle text-center" data-id="{{ $todo->id }}">
    <td style="width: 5%;">{{ $index }}</td>
    <td style="width: 15%; overflow: hidden;" class="text-start">
        <div class="d-flex align-items-center gap-2">
            <span class="text-truncate d-inline-block" style="max-width: calc(100% - 2rem);" title="{{ $todo->title }}">{{ $todo->title }}</span>
            @if($todo->subtasks->count() > 0)
                <button class="no-visual-btn flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#subtasks-{{ $todo->id }}" aria-expanded="false" aria-controls="subtasks-{{ $todo->id }}">
                    <i class="bi bi-chevron-down"></i>
                </button>
            @endif
        </div>
    </td>
    <td style="width: 20%;" class="text-start">
        <div class="description-cell" title="{{ $todo->description }}">
            {{ $todo->description }}
        </div>
    </td>
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
                data-title="{{ $todo->title }}"
                title="Hapus">
            <i class="bi bi-trash"></i>
        </button>
    </td>
</tr>
@if($todo->subtasks->count() > 0)
<tr>
    <td colspan="7" class="p-0" style="border-top: none;">
        <div class="collapse" id="subtasks-{{ $todo->id }}">
            <div class="p-3 bg-light" style="width: 100%; overflow: hidden">
                <h6 class="mb-3">Subtasks:</h6>
                    @foreach($todo->subtasks as $subtask)
                    <div class="d-flex align-items-center gap-2">
                        <input class="form-check-input subtask-checkbox flex-shrink-0" type="checkbox" data-subtask-id="{{ $subtask->id }}" {{ $subtask->is_done ? 'checked' : '' }}>
                        <span class="text-truncate text-wrap d-inline-block {{ $subtask->is_done ? 'text-decoration-line-through text-muted' : '' }}" title="{{ $subtask->name }}">{{ $subtask->name }}</span>
                    </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </td>
</tr>
@endif
