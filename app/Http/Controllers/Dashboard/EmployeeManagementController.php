<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('id', '!=', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && in_array($request->role, ['employee', 'employer'])) {
            $query->where('role', $request->role);
        }

        $employees = $query->latest()->paginate(10)->withQueryString();

        return view('users.employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employees' => 'required|array',
            'employees.*.name' => 'required|string|max:255',
            'employees.*.email' => 'required|email|unique:users,email',
            'employees.*.password' => 'required|string',
            'employees.*.role' => 'required|in:employee,employer',
        ]);

        $newRowsHtml = '';

        foreach ($validated['employees'] as $data) {
            $user = new User();

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->role = $data['role'];

            $user->save();

            $newRowsHtml .= view('users.employees.partials.row', ['employee' => $user])->render();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Semua data karyawan berhasil ditambahkan!',
            'html' => $newRowsHtml,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:employee,employer',
            'password' => 'nullable|string',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diperbarui!',
            'html' => view('users.employees.partials.row', ['employee' => $user])->render(),
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Karyawan berhasil dihapus.'
        ]);
    }
}
