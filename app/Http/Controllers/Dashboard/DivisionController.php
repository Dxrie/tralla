<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::query()->orderBy('name')->get();

        return view('users.divisions.index', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:divisions,name'],
        ]);

        Division::create([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}
