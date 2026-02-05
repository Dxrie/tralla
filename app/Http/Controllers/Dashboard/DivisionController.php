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

        $division = Division::create([
            'name' => $validated['name'],
        ]);

        $count = Division::count();

        $html = view('users.divisions.partials.row', [
            'division' => $division,
            'loop' => (object) ['iteration' => $count]
        ])->render();

        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil ditambahkan.',
            'html' => $html,
        ], 201);
    }

    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:divisions,name,' . $division->id],
        ]);

        $division->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}
