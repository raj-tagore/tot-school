<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomSettings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function markAttendance()
    {
        $zoomLinkSetting = CustomSettings::where('name', 'Zoom meeting link')->first();
        $zoomLink        = $zoomLinkSetting ? $zoomLinkSetting->value : null;

        $user  = Auth::user();
        $today = Carbon::today();

        if ($user->admin) {
            if (!$user->last_attendance_date || !$user->last_attendance_date->isSameDay($today)) {
                User::query()->increment('total');
                $user->update(['last_attendance_date' => $today]);
            }
        } else {
            if (!$user->last_attendance_date || !$user->last_attendance_date->isSameDay($today)) {
                $user->increment('presents');
                $user->update(['last_attendance_date' => $today]);
            }
        }

        return response()->json([
            'message'  => 'Attendance marked successfully',
            'zoom_link' => $zoomLink,
        ], 200);
    }
}
