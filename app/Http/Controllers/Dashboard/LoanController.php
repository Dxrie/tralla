<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Loan;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->division) {
            $division = Division::where('name', $request->division)->first();
            if ($division) {
                $query->where('division_id', $division->id);
            }
        }

        if ($request->bulan) {
            $query->whereMonth('date', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('date', $request->tahun);
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $loans = $query->with('loanItems')->orderBy('date', 'desc')->paginate($perPage);

        if ($request->ajax()) {
            $html = '';
            foreach ($loans as $index => $loan) {
                $index = ($loans->currentPage() - 1) * $loans->perPage() + $index + 1;
                $html .= view('users.loans.partials.table-row', ['loan' => $loan, 'index' => $index])->render();
            }
            if ($loans->isEmpty()) {
                $html = '<tr class="text-center"><td colspan="6">Belum ada data</td></tr>';
            }
            $pagination = '';
            if ($loans->hasPages()) {
                $pagination = $loans->appends($request->query())->links()->toHtml();
            }

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

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

        $divisions = Division::all();
        $userDivision = Auth::user()->division;
        return view('users.loans.index', compact('loans', 'divisions', 'months', 'years', 'userDivision'));
    }
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date'          => 'required|date',
            'division_id'   => ['required', Rule::exists('divisions', 'id')],
            'items'         => 'required|array',
            'items.*'  => 'required|string',
        ]);

        $loan = Loan::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'date'        => $validated['date'],
            'division_id' => $validated['division_id'],
        ]);

        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $name) {
                if (trim($name) === '') continue;

                $loan->loanItems()->create([
                    'name' => $name,
                ]);
            }
        }
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date'          => 'required|date',
            'division_id'   => ['required', Rule::exists('divisions', 'id')],
            'items'         => 'required|array',
            'items.*'       => 'required|string',
        ]);

        $division = Division::where('id', $validated['division_id'])->first();

        $loan->update($validated);

        $existingItems = $loan->loanItems;
        if (!empty($request->items)) {
            foreach ($request->items as $index => $name) {
                $name = trim($name);
                if ($name === '') continue;

                if ($index < $existingItems->count()) {
                    // Update existing item
                    $existingItems[$index]->update(['name' => $name]);
                } else {
                    // Create new item
                    $loan->loanItems()->create(['name' => $name]);
                }
            }
        }

        return response()->json([
            'message' => 'Loan has been successfully updated.',
            'id' => $loan->id,
        ]);
    }
    
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->json(['message' => 'Deleted successfully', 'id' => $loan->id]);
    }
}
