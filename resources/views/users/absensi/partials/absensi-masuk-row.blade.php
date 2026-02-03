<tr>
    <td style="width: 5%;">1</td>
    <td style="width: 25%;">{{ $entry->user->name }}</td>

    <td style="width: 25%;">
        @if ($entry->status === 'ontime')
            <span class="badge bg-success">Hadir (On Time)</span>
        @elseif ($entry->status === 'absent')
            <span class="badge bg-warning text-dark">Izin (Absen)</span>
        @else
            <span class="badge bg-danger">Terlambat</span>
        @endif
    </td>

    {{-- Display Date (e.g., 21 January 2026) --}}
    <td style="width: 15%;">{{ $entry->created_at->format('d F Y') }}</td>

    {{-- Display Time (e.g., 08:30:00) --}}
    <td style="width: 20%;">{{ $entry->created_at->format('H:i:s') }}</td>

    <td style="width: 10%;">
        @if ($entry->image_path)
            {{-- Link to view the proof in a new tab --}}
            <a href="{{ Storage::url($entry->image_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-eye"></i> Lihat Bukti
            </a>
        @else
            <span class="text-muted small">Tidak ada foto</span>
        @endif
    </td>
</tr>
