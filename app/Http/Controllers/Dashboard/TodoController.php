<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'tanggal' => 'required|date',
            'description' => 'nullable|string'
        ]);

        Todo::create($request->all());

        return redirect()->route('todo.index')
                         ->with('success', 'Data berhasil ditambahkan!');
    }

    public function index(Request $request)
    {
        $query = Todo::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $todos = $query->orderBy('tanggal', 'desc')->get();

        $statuses = ['to-do', 'on progress', 'hold', 'done'];

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $years = [];
        $currentYear = now()->year;
        for ($i = $currentYear - 3; $i <= $currentYear + 1; $i++) {
            $years[] = $i;
        }

        return view('todos.index', compact('todos', 'statuses', 'months', 'years'));
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'tanggal' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->status === 'done' && $todo->tanggal_selesai === null) {
            $data['tanggal_selesai'] = now();
        }

        if ($request->status !== 'done') {
            $data['tanggal_selesai'] = null;
        }

        $todo->update($data);

        return redirect()->route('todo.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todo.index');
    }
}
