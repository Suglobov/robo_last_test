<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            return;
            $defferred_operations = DB::table('defferred_operations')
                ->where('operation_completed', false)
                ->where('operation_datetime', '<', 'NOW()')
                ->get();

            foreach ($defferred_operations as $do) {
                DB::transaction(function () use ($do) {
                    // понижаем баланс
                    DB::table('users')
                        ->where('id', $do->user_id_from)
                        ->decrement('amount', $do->amount);
                    $user_from = DB::table('users')->where('id', $do->user_id_from)->get();
                    //                    print_r($user_from[0]->amount);
                    if ($user_from[0]->amount < 0) {
                        Session::put(
                            'warning',
                            'Была попытка понизить банас пользователя ' . $user_from->id . ' ниже нуля'
                        );
                        throw new \Exception(
                            'Была попытка понизить банас пользователя '
                            . $user_from->id .
                            ' ниже нуля'
                        );
                    }

                    // повышаем баланс
                    DB::table('users')
                        ->where('id', $do->user_id_to)
                        ->increment('amount', $do->amount);

                    DB::table('defferred_operations')
                        ->where('id', $do->id)
                        ->update(['operation_completed' => true]);
                });
            }
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
