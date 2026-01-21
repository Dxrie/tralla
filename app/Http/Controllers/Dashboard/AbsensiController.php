<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EntryActivity;
use App\Models\ExitActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    public function masuk()
    {
        $todaysEntries = EntryActivity::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        return view('users.absensi.absensi-masuk', compact('todaysEntries'));
    }

    public function keluar()
    {
        $todaysEntries = ExitActivity::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        return view('users.absensi.absensi-keluar', compact('todaysEntries'));
    }

    public function masukStore(Request $request)
    {
        $validated = $request->validate([
            'image_base64' => 'required',
            'status' => ['required', Rule::in(['hadir', 'izin'])],
        ]);

        $deadline = Carbon::now()->setTime(9, 0, 0);
        $status = $validated['status'] === 'hadir' ? (Carbon::now()->greaterThan($deadline) ? 'late' : 'ontime') : 'absent';

        var_dump($status);

        $imagePath = null;

        if ($validated['image_base64']) {
            $image_parts = explode(';base64,', $validated['image_base64']);
            $image_base64 = base64_decode($image_parts[1]);

            $filePath = 'absensi_masuk/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filePath, $image_base64);
            $imagePath = $filePath;
        }

        EntryActivity::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
            'status' => $status,
        ]);

        $message = $status === 'late'
            ? 'Absensi berhasil, namun anda tercatat terlambat.'
            : 'Absensi berhasil! Selamat bekerja.';

        return redirect()->back()->with('success', $message);
    }

    public function keluarStore(Request $request)
    {
        $validated = $request->validate([
            'image_base64' => 'required',
        ]);

        $imagePath = null;

        if ($validated['image_base64']) {
            $image_parts = explode(';base64,', $validated['image_base64']);
            $image_base64 = base64_decode($image_parts[1]);

            $filePath = 'absensi_keluar/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filePath, $image_base64);
            $imagePath = $filePath;
        }

        ExitActivity::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
        ]);

        $message = 'Absensi berhasil! Hati-hati di Jalan.';

        return redirect()->back()->with('success', $message);
    }
}
