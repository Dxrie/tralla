<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logFile)) {
            $fileContent = File::get($logFile);
            $lines = explode("\n", $fileContent);
            
            // Read in reverse order to show newest first
            $lines = array_reverse($lines);

            foreach ($lines as $line) {
                if (empty(trim($line))) {
                    continue;
                }

                // Look for our specific log messages
                if (str_contains($line, 'User created by admin') || str_contains($line, 'New user registered:')) {
                    // Extract timestamp (assuming standard Laravel log format: [YYYY-MM-DD HH:MM:SS] environment.LEVEL: message)
                    preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $matches);
                    $timestamp = $matches[1] ?? 'N/A';
                    
                    // Extract message
                    $messagePart = explode(']: ', $line, 2);
                    $message = $messagePart[1] ?? $line;

                    // Clean up message
                    $message = preg_replace('/\w+\.INFO: /', '', $message);

                    $logs[] = [
                        'timestamp' => $timestamp,
                        'message' => $message,
                        'original' => $line
                    ];
                }
            }
        }

        return view('users.logs.index', compact('logs'));
    }
}
