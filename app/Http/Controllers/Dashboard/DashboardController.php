<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EntryActivity;
use App\Models\ExitActivity;
use App\Models\Absent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // For employers: show all employees' data
        // For employees: show only their own data
        $user = Auth::user();
        
        if ($user->role === 'employer') {
            // Get all employees
            $employees = User::where('role', 'employee')->get();
            
            // Today's entry activities
            $todaysEntries = EntryActivity::whereDate('created_at', $today)
                ->with('user')
                ->get();
                
            // Today's exit activities  
            $todaysExits = ExitActivity::whereDate('created_at', $today)
                ->with('user')
                ->get();
                
            // Pending absences
            $pendingAbsents = Absent::where('status', 'pending')
                ->with('user')
                ->latest()
                ->limit(5)
                ->get();
                
            // Statistics
            $totalEmployees = $employees->count();
            $presentToday = $todaysEntries->count();
            $absentToday = $totalEmployees - $presentToday;
            
            // Late entries
            $lateToday = $todaysEntries->where('status', 'late')->count();
            $onTimeToday = $todaysEntries->where('status', 'ontime')->count();

            return view('users.index', compact(
                'user',
                'todaysEntries',
                'todaysExits',
                'pendingAbsents',
                'totalEmployees',
                'presentToday',
                'absentToday',
                'lateToday',
                'onTimeToday',
                'lateThisMonth',
                'onTimeThisMonth'
            ));
            
        } else {
            // Employee view - show only their data
            $todaysEntries = EntryActivity::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->get();
                
            $todaysExits = ExitActivity::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->get();
                
            $pendingAbsents = Absent::where('user_id', $user->id)
                ->where('status', 'pending')
                ->latest()
                ->limit(5)
                ->get();
                
            // Employee statistics
            $monthEntries = EntryActivity::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->get();
                
            $lateThisMonth = $monthEntries->where('status', 'late')->count();
            $onTimeThisMonth = $monthEntries->where('status', 'ontime')->count();
            return view('users.index', compact(
                'user',
                'todaysEntries',
                'todaysExits',
                'pendingAbsents',
                'lateThisMonth',
                'onTimeThisMonth'
        ));
        }
        
    }
}