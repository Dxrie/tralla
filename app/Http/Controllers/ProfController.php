<?php

namespace App\Http\Controllers;

use App\Models\Prof;
use Illuminate\Http\Request;

class ProfController extends Controller
{
    public function create()
    {
        return view('profs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'vaksin' => 'required|in:belum,vaksin-1,vaksin-2',
            'kuliah' => 'required|in:tidak kuliah,sudah'
        ]);

        Prof::create($request->all());

        return redirect('/profs');
    }

    public function index()
    {
        $profs = Prof::all();
        return view('profs.index', compact('profs'));
    }

    public function edit(Prof $prof)
    {
        return view('profs.edit', compact('prof'));
    }

    public function update(Request $request, Prof $prof)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email,' . $prof->id,
            'vaksin' => 'required|in:belum,vaksin-1,vaksin-2',
            'kuliah' => 'required|in:tidak kuliah,sudah'
        ]);

        $prof->update($request->all());

        return redirect('/profs');
    }

    public function destroy(Prof $prof)
    {
        $prof->delete();
        return redirect('/profs');
    }
}
