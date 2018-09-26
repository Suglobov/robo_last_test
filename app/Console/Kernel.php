<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
            $defferred_operations = DB::select(
                'SELECT * FROM `defferred_operations`
                  WHERE timestamp(operation_datetime) < NOW()
                  AND operation_completed = false'
            );
//            echo print_r($defferred_operations, 1) . PHP_EOL;
            foreach ($defferred_operations as $do) {
                DB::beginTransaction();
                try {
                    $user_from = DB::table('users')->where('id', $do->user_id_from)->get();
                    if ($user_from[0]->amount - $do->amount < 0) {
                        $message = 'попытка понизить банас пользователя '
                            . $user_from[0]->id .
                            ' ниже нуля.';
                        $tmpError = DB::table('errors_defferred_operations')
                            ->where('defferred_operations_id', $do->id)
                            ->get();
                        if (count($tmpError) === 0) {
//                            echo print_r(Carbon::now()->toDateTimeString(), 1) . PHP_EOL;
                            DB::table('errors_defferred_operations')
                                    ->insert([
                                        'defferred_operations_id' => $do->id,
                                        'date'                    => Carbon::now(),
                                        'message'                 => $message,
                                    ]);
                        }
                    } else {
                        // понижаем баланс
                        DB::table('users')
                            ->where('id', $do->user_id_from)
                            ->decrement('amount', $do->amount);
                        // повышаем баланс
                        DB::table('users')
                            ->where('id', $do->user_id_to)
                            ->increment('amount', $do->amount);
                        DB::table('defferred_operations')
                            ->where('id', $do->id)
                            ->update(['operation_completed' => true]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    print_r('rollback');
                    DB::rollback();
                }
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
