<tr class="align-middle text-center" data-id="{{ $todo->id }}">
    <td style="width: 5%;">{{ $index }}</td>
    <td style="width: 15%;" class="text-start">
        <div class="truncate-cell" title="{{ $todo->title }}">
            {{ $todo->title }}
        </div>
    </td>
    <td style="width: 20%;" class="text-start">
        <div class="truncate-cell" title="{{ $todo->description ?: '-' }}">
            {{ $todo->description ?: '-' }}
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
            class="btn btn-outline-warning btn-sm viewTodoBtn"
            data-id="{{ $todo->id }}"
            data-title="{{ $todo->title }}"
            data-description="{{ $todo->description }}"
            data-status="{{ $todo->status }}"
            data-start_date="{{ $todo->start_date }}"
            data-finish_date="{{ $todo->finish_date }}"
            data-subtasks='@json($todo->subtasks->map(function($subtask) { return ["id" => $subtask->id, "name" => $subtask->name, "is_done" => $subtask->is_done]; }))'
            data-bs-toggle="modal"
            data-bs-target="#viewModal"
        >
            <i class="bi bi-eye"></i>
        </button>

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
