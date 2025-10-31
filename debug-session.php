<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "=== DEBUG SESSION INFO ===\n\n";

// Get all active sessions
$sessions = DB::table('sessions')->get();
echo "Total sessions: " . $sessions->count() . "\n\n";

// Get latest session
$latest = DB::table('sessions')
    ->orderBy('last_activity', 'desc')
    ->first();

if ($latest) {
    echo "Latest session:\n";
    echo "- Session ID: " . $latest->id . "\n";
    echo "- User ID: " . ($latest->user_id ?? 'NULL (not logged in)') . "\n";
    echo "- IP: " . $latest->ip_address . "\n";
    echo "- Last Activity: " . date('Y-m-d H:i:s', $latest->last_activity) . "\n\n";
    
    if ($latest->user_id) {
        $user = User::find($latest->user_id);
        if ($user) {
            echo "User Details:\n";
            echo "- ID: " . $user->id . "\n";
            echo "- Name: " . $user->name . "\n";
            echo "- Email: " . $user->email . "\n";
            echo "- Role: " . $user->role . "\n";
            echo "- Status: " . $user->status . "\n";
            echo "- Google ID: " . ($user->google_id ?? 'NULL') . "\n";
        }
    }
}

// Get sessions with user_id = 26 (your user)
echo "\n=== SESSIONS FOR USER 26 ===\n";
$user26Sessions = DB::table('sessions')->where('user_id', 26)->get();
echo "Total: " . $user26Sessions->count() . "\n";

foreach ($user26Sessions as $session) {
    echo "- Session: " . $session->id . " (Last activity: " . date('Y-m-d H:i:s', $session->last_activity) . ")\n";
}
