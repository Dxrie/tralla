<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah To-Do</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <form action="/todos" method="POST">
            @csrf

            <a href="/" class="btn btn-secondary mb-3">Lihat Data</a>
            <br><br>

            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" class="form-control">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="description" class="form-control">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="to-do">to-do</option>
                    <option value="on progress">on progress</option>
                    <option value="hold">hold</option>
                    <option value="done">done</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                >
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</body>
</html>