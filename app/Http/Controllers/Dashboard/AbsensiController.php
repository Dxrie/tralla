<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EntryActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        return view('users.absensi.absensi-keluar');
    }

    public function masukStore(Request $request)
    {
        $validated = $request->validate([
            'image_base64' => 'required',
        ]);

        $deadline = Carbon::now()->setTime(9, 0, 0);
        $status = Carbon::now()->greaterThan($deadline) ? 'late' : 'ontime';

        $imagePath = null;

        if ($validated['image_base64']) {
            $image_parts = explode(';base64,', $validated['image_base64']);
            $image_base64 = base64_decode($image_parts[1]);

            $filePath = 'absensi/' . uniqid() . '.jpg';
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
}
