<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <a href="/" class="btn btn-secondary mb-3">← Kembali</a>

        <br><br>

        <form action="/todos/{{ $todo->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" class="form-control" value="{{ $todo->title }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="description" class="form-control" value="{{ $todo->description }}">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="to-do" {{ $todo->status == 'to-do' ? 'selected' : '' }}>to-do</option>
                    <option value="on progress" {{ $todo->status == 'on progress' ? 'selected' : '' }}>on progress</option>
                    <option value="hold" {{ $todo->status == 'hold' ? 'selected' : '' }}>hold</option>
                    <option value="done" {{ $todo->status == 'done' ? 'selected' : '' }}>done</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $todo->tanggal }}">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</body>
</html>