<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function announcement() {
        $announcement = CustomSettings::where('name', 'announcement')->first();
        return response()->json(['value' => $announcement->value]);
    }
}