<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function masuk()
    {
        return view('users.absensi.absensi-masuk');
    }

    public function keluar()
    {
        return view('users.absensi.absensi-keluar');
    }
}
