<form action="/todos" method="POST">
    @csrf

    <a href="/">Lihat Data</a>
    <br><br>

    <div>
        <label>Judul</label>
        <input type="text" name="title">
    </div>

    <div>
        <label>Deskripsi</label>
        <input type="text" name="description">
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="to-do">to-do</option>
            <option value="on progress">on progress</option>
            <option value="hold">hold</option>
            <option value="done">done</option>
        </select>
    </div>

    <div>
        <label>Tanggal</label>
        <input
            type="date"
            name="tanggal"
            value="{{ date('Y-m-d') }}"
        >
    </div>

    <button type="submit">Simpan</button>
</form>
