<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $from = $request->filled('from') ? Carbon::parse($request->string('from'))->startOfDay() : null;
        $to = $request->filled('to') ? Carbon::parse($request->string('to'))->endOfDay() : null;

        $query = Absent::with('user');

        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        } elseif ($from) {
            $query->where('created_at', '>=', $from);
        } elseif ($to) {
            $query->where('created_at', '<=', $to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absents = $query->latest()->paginate($perPage)->withQueryString();
        return view('users.izin.index', compact('absents'));
    }
}
