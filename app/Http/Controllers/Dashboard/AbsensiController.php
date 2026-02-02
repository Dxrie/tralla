<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absent;
use App\Models\EntryActivity;
use App\Models\ExitActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    public function masuk(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        // Default: today, but allow date-range browsing via query params.
        $from = $request->filled('from') ? Carbon::parse($request->string('from'))->startOfDay() : Carbon::today()->startOfDay();
        $to = $request->filled('to') ? Carbon::parse($request->string('to'))->endOfDay() : Carbon::today()->endOfDay();

        // Start Query
        $query = EntryActivity::with('user')
            ->whereBetween('created_at', [$from, $to]);

        // 1. Search by Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Pagination
        $todaysEntries = $query->latest()->paginate($perPage)->withQueryString();
        $state = 'masuk';

        return view('users.absensi.absensi-masuk', compact('todaysEntries', 'state'));
    }

    public function keluar(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $from = $request->filled('from') ? Carbon::parse($request->string('from'))->startOfDay() : Carbon::today()->startOfDay();
        $to = $request->filled('to') ? Carbon::parse($request->string('to'))->endOfDay() : Carbon::today()->endOfDay();

        $query = ExitActivity::with('user')
            ->whereBetween('created_at', [$from, $to]);

        // Search by Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $todaysEntries = $query->latest()->paginate($perPage)->withQueryString();

        return view('users.absensi.absensi-keluar', compact('todaysEntries'));
    }

    public function masukStore(Request $request)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['hadir', 'izin'])],
            'image_base64' => 'required_if:status,hadir',
            'keterangan' => 'required_if:status,izin',
        ]);

        $todayEntry = EntryActivity::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($todayEntry) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah melakukan absen masuk hari ini.',
            ], 400);
        }

        $deadline = Carbon::now()->setTime(9, 0, 0);

        if ($validated['status'] === 'hadir') {
            $status = Carbon::now()->greaterThan($deadline) ? 'late' : 'ontime';

            $image_parts = explode(';base64,', $validated['image_base64']);
            $image_base64 = base64_decode($image_parts[1]);

            $filePath = 'absensi_masuk/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filePath, $image_base64);

            $entry = EntryActivity::create([
                'user_id'    => Auth::id(),
                'status'     => $status,
                'image_path' => $filePath,
            ]);
        } else {
            $status = 'absent';

            Absent::create([
                'user_id' => Auth::id(),
                'detail' => $validated['keterangan'],
            ]);
        }

        if ($status === 'absent') {
            $message = 'Izin berhasil diajukan.';
        } else {
            $html = view('users.absensi.partials.absensi-masuk-row', compact('entry'))->render();

            $message = $status === 'late'
                ? 'Absensi berhasil, namun anda tercatat terlambat.'
                : 'Absensi berhasil! Selamat bekerja.';
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => $status === 'late' ? 'Absensi Terlambat' : 'Absensi Berhasil',
                'icon' => $status === 'late' ? 'warning' : 'success',
            ],
            'message' => $message,
            'redirect' => $status === 'absent' ? route('izin.index') : null,
            'html' => $html ?? null,
        ], 201);
    }

    public function keluarStore(Request $request)
    {
        $validated = $request->validate([
            'image_base64' => 'required',
        ]);

        $todayExit = ExitActivity::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($todayExit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah melakukan absen pulang hari ini.',
            ], 400);
        }

        $todayEntry = EntryActivity::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$todayEntry) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum melakukan absen masuk hari ini.'
            ], 400);
        }

        $imagePath = null;

        if ($validated['image_base64']) {
            $image_parts = explode(';base64,', $validated['image_base64']);
            $image_base64 = base64_decode($image_parts[1]);

            $filePath = 'absensi_keluar/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filePath, $image_base64);
            $imagePath = $filePath;
        }

        $entry = ExitActivity::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
        ]);

        $message = 'Absensi berhasil! Hati-hati di Jalan.';
        $html = view('users.absensi.partials.absensi-keluar-row', compact('entry'))->render();

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'redirect' => null,
            'html' => $html,
        ]);
    }
}
