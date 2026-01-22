<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absent;

class IzinController extends Controller
{
    public function index()
    {
        $absents = Absent::with('user')
            ->latest()
            ->get();
        return view('users.izin.index', compact('absents'));
    }
}
