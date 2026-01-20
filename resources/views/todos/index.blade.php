<a href="/todos">+ Tambah To-Do</a>

<br><br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($todos as $todo)
            <tr>
                <td>{{ $todo->id }}</td>
                <td>{{ $todo->title }}</td>
                <td>{{ $todo->description }}</td>
                <td>{{ $todo->status }}</td>
                <td>{{ $todo->tanggal }}</td>
                <td>
                    <a href="/todos/{{ $todo->id }}/edit">Edit</a>

                    <form action="/todos/{{ $todo->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
