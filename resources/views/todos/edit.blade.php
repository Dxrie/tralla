<a href="/">← Kembali</a>

<br><br>

<form action="/todos/{{ $todo->id }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Judul</label>
        <input type="text" name="title" value="{{ $todo->title }}">
    </div>

    <div>
        <label>Deskripsi</label>
        <input type="text" name="description" value="{{ $todo->description }}">
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="to-do" {{ $todo->status == 'to-do' ? 'selected' : '' }}>to-do</option>
            <option value="on progress" {{ $todo->status == 'on progress' ? 'selected' : '' }}>on progress</option>
            <option value="hold" {{ $todo->status == 'hold' ? 'selected' : '' }}>hold</option>
            <option value="done" {{ $todo->status == 'done' ? 'selected' : '' }}>done</option>
        </select>
    </div>

    <div>
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="{{ $todo->tanggal }}">
    </div>

    <button type="submit">Update</button>
</form>
