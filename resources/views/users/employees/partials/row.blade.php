{{-- resources/views/users/employees/partials/row.blade.php --}}
<tr id="employee-row-{{ $employee->id }}">
    <td>{{ $employee->name }}</td>
    <td>{{ $employee->email }}</td>
    <td>
        <span class="badge {{ $employee->role == 'employer' ? 'bg-primary' : 'bg-secondary' }}">
            {{ ucfirst($employee->role) }}
        </span>
    </td>
    <td>{{ $employee->created_at->format('d M Y') }}</td>
    <td class="text-end">
        {{-- Edit Button: Stores the full employee object in data-json for easy access in JS --}}
        <button type="button" class="btn btn-sm btn-warning me-1 btn-edit" data-id="{{ $employee->id }}"
            data-json="{{ json_encode($employee) }}">
            <i class="bi bi-pencil-square"></i>
        </button>

        {{-- Delete Button --}}
        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $employee->id }}"
            data-name="{{ $employee->name }}">
            <i class="bi bi-trash"></i>
        </button>
    </td>
</tr>
