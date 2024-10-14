<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomSettings;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function markAttendance()
    {
        $zoom_link = CustomSettings::where('name', 'Zoom meeting link')->first();

        $user = Auth::user();
        $today = Carbon::today();

        if ($user->admin) {
            // User is admin, increment 'total' for all users
            // Check if the admin has already incremented 'total' today
            if (!$user->last_attendance_date || !$user->last_attendance_date->isSameDay($today)) {
                dd($user->last_attendance_date, $today, $user->last_attendance_date !== $today);
                User::query()->increment('total');
                // Update admin's last attendance date
                $user->update(['last_attendance_date' => $today]);
            }
        } else {
            // User is not admin, check if they've already marked attendance today
            if (!$user->last_attendance_date || !$user->last_attendance_date->isSameDay($today)) {
                // Increment 'presents' count
                $user->increment('presents');
                // Update user's last attendance date
                $user->update(['last_attendance_date' => $today]);
            }
        }

        return redirect()->away($zoom_link['value']);
    }
}
