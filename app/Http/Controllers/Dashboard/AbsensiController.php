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
    public function masuk()
    {
        $todaysEntries = EntryActivity::with('user')
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        return view('users.absensi.absensi-masuk', compact('todaysEntries'));
    }

    public function keluar()
    {
        $todaysEntries = ExitActivity::with('user')
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        return view('users.absensi.absensi-keluar', compact('todaysEntries'));
    }

    public function masukStore(Request $request)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['hadir', 'izin'])],
            'image_base64' => 'required_if:status,hadir',
            'keterangan' => 'required_if:status,izin',
        ]);

        $deadline = Carbon::now()->setTime(9, 0, 0);

        if ($validated['status'] === 'hadir') {
            $status = Carbon::now()->greaterThan($deadline) ? 'late' : 'ontime';

            $image_parts = explode(';base64,', $validated['image_base64']);
            $image_base64 = base64_decode($image_parts[1]);

            $filePath = 'absensi_masuk/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filePath, $image_base64);

            EntryActivity::create([
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

            return redirect()->route('izin.index')->with('success', $message);
        } else {
            $message = $status === 'late'
                ? 'Absensi berhasil, namun anda tercatat terlambat.'
                : 'Absensi berhasil! Selamat bekerja.';
        }

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
