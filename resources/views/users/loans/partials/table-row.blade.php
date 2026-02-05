<tr class="align-middle text-center" data-id="{{ $loan->id }}">
    <td style="width: 5%;">{{ $index }}</td>
    <td style="width: 20%;" class="text-start">
        <div class="truncate-cell" title="{{ $loan->title }}">
            {{ $loan->title }}
        </div>
    </td>
    <td style="width: 20%;" class="text-start">
        <div class="truncate-cell" title="{{ $loan->description ?: '-' }}">
            {{ $loan->description ?: '-' }}
        </div>
    </td>
    <td style="width: 15%;">{{ \Carbon\Carbon::parse($loan->date)->format('d-m-Y') }}</td>
    <td style="width: 15%;">{{ $loan->division->name }}</td>
    <td class="text-nowrap" style="width: 15%;">
        {{-- Button View --}}
        <button
            class="btn btn-outline-warning btn-sm viewLoanBtn"
            data-id="{{ $loan->id }}"
            data-title="{{ $loan->title }}"
            data-description="{{ $loan->description }}"
            data-date="{{ $loan->date }}"
            data-division="{{ $loan->division->name }}"
            data-bs-toggle="modal"
            data-bs-target="#viewModal"
        >
        <i class="bi bi-eye"></i>
        </button>

        {{-- Button Update --}}
        <button
            class="btn btn-outline-primary btn-sm editLoanBtn"
            data-id="{{ $loan->id }}"
            data-title="{{ $loan->title }}"
            data-description="{{ $loan->description }}"
            data-date="{{ $loan->date }}"
            data-division_id="{{ $loan->division_id }}"
            data-items='@json($loan->loanItems->pluck("name")->toArray())'
            data-bs-toggle="modal"
            data-bs-target="#formModal"
        >
            <i class="bi bi-pencil-square"></i>
        </button>

        {{-- Button Delete --}}
        <button type="button"
                class="btn btn-outline-danger btn-sm px-2 py-1 deleteLoanBtn"
                data-id="{{ $loan->id }}"
                data-title="{{ $loan->title }}"
                title="Hapus">
            <i class="bi bi-trash"></i>
        </button>
    </td>
</tr>
