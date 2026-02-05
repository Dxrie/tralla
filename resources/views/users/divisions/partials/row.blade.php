<tr id="division-{{ $division->id }}">
    <td class="text-center text-muted">{{ $loop->iteration }}</td>
    <td class="fw-medium">{{ $division->name }}</td>
    <td class="text-end pe-4">
        <div class="btn-group" role="group">
            {{-- Edit Button --}}
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                data-id="{{ $division->id }}" data-name="{{ $division->name }}">
                <i class="bi bi-pencil-square"></i>
            </button>

            {{-- Delete Button --}}
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $division->id }}"
                data-name="{{ $division->name }}">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </td>
</tr>
