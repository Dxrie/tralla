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

        return redirect()->route('todo.index');
    }

    public function index()
    {
        $todos = Todo::orderBy('tanggal', 'desc')->get();
        return view('todos.index', compact('todos'));
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
