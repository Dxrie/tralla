<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do</title>
</head>
<body>

    <h2>Edit To-Do</h2>

    <a href="/">Kembali</a>

    <br><br>

    <form action="/todos/{{ $todo->id }}" method="POST">
        @csrf
        @method('PUT')

        <label>Judul</label><br>
        <input
            type="text"
            name="title"
            value="{{ $todo->title }}"
        >
        <br><br>

        <label>Deskripsi</label><br>
        <input
            type="text"
            name="description"
            value="{{ $todo->description }}"
        >
        <br><br>

        <label>Status</label><br>
        <select name="status">
            <option value="to-do" {{ $todo->status == 'to-do' ? 'selected' : '' }}>to-do</option>
            <option value="on progress" {{ $todo->status == 'on progress' ? 'selected' : '' }}>on progress</option>
            <option value="hold" {{ $todo->status == 'hold' ? 'selected' : '' }}>hold</option>
            <option value="done" {{ $todo->status == 'done' ? 'selected' : '' }}>done</option>
        </select>
        <br><br>

        <label>Tanggal</label><br>
        <input
            type="date"
            name="tanggal"
            value="{{ $todo->tanggal }}"
        >
        <br><br>

        <button type="submit">Update</button>
    </form>

</body>
</html>
