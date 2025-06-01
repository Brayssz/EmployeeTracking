<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DailyRecord;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function show(Request $request)
    {
        return view('contents.login');
    }

    public function dashboard(Request $request)
    {
        $today = Carbon::today();

        $present = User::where('status', 'active')
            ->whereHas('dailyAttendance', function ($query) use ($today) {
                $query->whereDate('created_at', $today)->where('status', 'present');
            })
            ->count();

        $absent = User::where('status', 'active')
            ->whereHas('dailyAttendance', function ($query) use ($today) {
                $query->whereDate('created_at', $today)->where('status', 'absent');
            })
            ->count();

        $ontravel = User::where('status', 'ontravel')->count();
        $onleave = User::where('status', 'onleave')->count();

        return view('contents.dashboard', compact('present', 'absent', 'ontravel', 'onleave'));
    }
    /**
     * Handle login authentication.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->position === 'Admin') {
                return redirect()->intended('/tracking') // Change this to your home page
                    ->with('success', 'Login successful');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Access denied'])->withInput();
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
