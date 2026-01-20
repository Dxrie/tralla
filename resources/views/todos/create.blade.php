<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah To-Do</title>
</head>
<body>

    <h2>Tambah To-Do</h2>

    <a href="/">Lihat Data</a>

    <br><br>
    @if ($errors->any())
        <p style="color: red;">
            {{ $errors->first('title') }}
        </p>
    @endif


    <form action="/todos" method="POST">
        @csrf

        <label>Judul</label><br>
        <input type="text" name="title">
        <br><br>

        <label>Deskripsi</label><br>
        <input type="text" name="description">
        <br><br>

        <label>Status</label><br>
        <select name="status">
            <option value="to-do">to-do</option>
            <option value="on progress">on progress</option>
            <option value="hold">hold</option>
            <option value="done">done</option>
        </select>
        <br><br>

        <label>Tanggal</label><br>
        <input
            type="date"
            name="tanggal"
            value="{{ date('Y-m-d') }}"
        >
        <br><br>

        <button type="submit">Simpan</button>
    </form>

</body>
</html>
