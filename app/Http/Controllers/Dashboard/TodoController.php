<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->bulan) {
            $query->whereMonth('start_date', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('start_date', $request->tahun);
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $todos = $query->with('subtasks')->orderBy('start_date', 'desc')->paginate($perPage);

        if ($request->ajax()) {
            $html = '';
            foreach ($todos as $index => $todo) {
                $index = ($todos->currentPage() - 1) * $todos->perPage() + $index + 1;
                $html .= view('users.todos.partials.table_row', compact('todo', 'index'))->render();
            }
            if ($todos->isEmpty()) {
                $html = '<tr class="text-center"><td colspan="7">Belum ada data</td></tr>';
            }
            $pagination = '';
            if ($todos->hasPages()) {
                $pagination = $todos->appends($request->query())->links()->toHtml();
            }

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

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

        return view('users.todos.index', compact('todos', 'statuses', 'months', 'years'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string',
            'start_date'  => 'required|date',
            'finish_date' => 'nullable|date',
            'subtasks'    => 'nullable|array',
            'subtasks.*'  => 'nullable|string|max:255',
        ]);
        
        $todo = Todo::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'],
            'start_date'  => $validated['start_date'],
            'finish_date' => $validated['finish_date'] ?? null,
        ]);

        if (!empty($validated['subtasks'])) {
            foreach ($validated['subtasks'] as $name) {
                if (trim($name) === '') continue;

                $todo->subtasks()->create([
                    'name'    => $name,
                    'is_done' => false,
                ]);
            }
        }

        return response()->json([
            'message' => 'Created successfully',
        ]);
    }

    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'status' => 'required',
            'start_date' => 'date',
            'finish_date' => 'nullable|date',
            'description' => 'nullable|string',
            'subtasks' => 'nullable|array',
            'subtasks.*' => 'nullable|string|max:255'
        ]);

        $data = $validated;

        if ($request->status === 'done' && !$request->filled('finish_date') && $todo->finish_date === null) {
            $data['finish_date'] = now();
        }

        $todo->update($data);

        // Handle subtasks: update existing ones, add new ones
        $existingSubtasks = $todo->subtasks;
        if (!empty($request->subtasks)) {
            foreach ($request->subtasks as $index => $name) {
                $name = trim($name);
                if ($name === '') continue;

                if ($index < $existingSubtasks->count()) {
                    // Update existing subtask
                    $existingSubtasks[$index]->update(['name' => $name]);
                } else {
                    // Create new subtask
                    $todo->subtasks()->create([
                        'name' => $name,
                        'is_done' => false,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Todo have successfully been updated.',
            'id' => $todo->id,
        ]);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(['message' => 'Deleted successfully', 'id' => $todo->id]);
    }

    public function toggleSubtask(Subtask $subtask)
    {
        $subtask->update(['is_done' => !$subtask->is_done]);

        return response()->json([
            'message' => 'Subtask updated successfully',
            'is_done' => $subtask->is_done,
        ]);
    }
}
