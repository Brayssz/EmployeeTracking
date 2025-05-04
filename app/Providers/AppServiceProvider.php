<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\DailyAttendance;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $now = Carbon::now();
            $today = Carbon::today();

            if ($now->hour >= 17) {
                $users = User::where('status', 'active')
                    ->whereDoesntHave('dailyAttendance', function ($query) use ($today) {
                        $query->whereDate('date', $today);
                    })
                    ->get();

                foreach ($users as $user) {
                    DailyAttendance::create([
                        'user_id' => $user->id,
                        'date' => $today,
                        'status' => 'absent',
                    ]);
                }
            }
        });
    }
}
