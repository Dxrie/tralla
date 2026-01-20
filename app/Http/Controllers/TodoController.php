<?php

namespace App\Http\Controllers;

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

        return redirect('/');
    }

    public function index()
    {
        $todos = Todo::all();
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

        $todo->update($request->all());

        return redirect('/');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('/');
    }
}

