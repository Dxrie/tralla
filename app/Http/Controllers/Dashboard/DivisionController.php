<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::query()->orderBy('created_at')->get();

        return view('users.divisions.index', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'divisions' => 'required|array',
            'divisions.*.name' => 'required|string|max:255|unique:divisions,name',
        ]);

        $newRowsHtml = '';

        $count = Division::count();

        foreach ($validated['divisions'] as $data) {
            $division = Division::create(['name' => $data['name']]);

            $newRowsHtml .= view('users.divisions.partials.row', [
                'division' => $division,
                'loop' => (object)['iteration' => $count]
            ])->render();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Semua divisi berhasil ditambahkan!',
            'html' => $newRowsHtml,
        ], 200);
    }

    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:divisions,name,' . $division->id],
        ]);

        $division->update([
            'name' => $validated['name'],
        ]);

        $count = Division::count();

        $html = view('users.divisions.partials.row', [
            'division' => $division,
            'loop' => (object) ['iteration' => $count]
        ])->render();

        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil diperbarui.',
            'html' => $html,
        ], 200);
    }

    public function destroy(Division $division)
    {
        $division->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil dihapus.',
        ], 200);
    }
}
