<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefferredOperationController extends Controller
{
    public function defferredOperation(Request $request)
    {
        $this->validate($request, [
            'user_id_to' => 'required|integer',
            'summ'       => 'required',
            'date'       => 'required|date',
            'datenow'    => 'required|date',
        ], [
            'user_id_to' => 'не верный id пользователя',
            'date'       => 'неправильная дата операции',
            'datenow'    => 'неправильная дата пользователя',
        ]);

        $selectUser = $request->session()->get('sectedUser');
        $userTo = $request->input('user_id_to');
        $summ = $request->input('summ');
        $date = $request->input('date');
        $dateNow = $request->input('datenow');
        $users = DB::table('users')->get()->toArray();

        // проверим есть ли пользователь отправитель
        $selectUserFromDb = collect($users)
            ->filter(function ($value, $key) use ($selectUser) {
                return $value->id == $selectUser;
            })->toArray();
        if (count($selectUserFromDb) != 1) {
            return redirect('/')->withErrors(['Не верный id пользователя, отправителя']);
        }

        // проверим есть ли пользователь назначения
        $userToFromDb = collect($users)
            ->filter(function ($value, $key) use ($userTo) {
                return $value->id == $userTo;
            })->toArray();
        if (count($userToFromDb) != 1) {
            return redirect('/')->withErrors(['Не верный id пользователя назначения']);
        }

        // проверка на перевод самому себе
        if ($selectUser == $userTo) {
            return redirect('/')->withErrors(['Самому себе нельзя переводить']);
        }

        // проверим сумму на 0
        if ($summ == 0) {
            return redirect('/')->withErrors(['Сумма перевода не должна быть 0']);
        }

        $selectUserFromDb = array_values($selectUserFromDb);
        $deferredDB = DB::table('defferred_operations')
            ->select(DB::raw('sum(amount) as sum, user_id_from'))
            ->where('user_id_from', $selectUserFromDb[0]->id)
            ->where('operation_completed', false)
            ->groupBy('user_id_from')
            ->get();
        $deferred = count($deferredDB) === 0 ? 0 : $deferredDB[0]->sum;
        $available = $selectUserFromDb[0]->amount - $deferred;

        // проверка суммы на доспустимое значение
        if ($available < $summ) {
            return redirect('/')->withErrors(['Сумма превышает допустимое значение']);
        }

        $serverDate = new Carbon();
        $userDate = new Carbon($dateNow);
        $diffHoursDate = $userDate->diffInHours($serverDate, false);

        $operanionDate = new Carbon($date);
        $operanionDate->minute = 0;
        $operanionDate->second = 0;
        $operanionDate->addHour($diffHoursDate);

        // проверка времени операции.
        if ($serverDate->diffInMinutes($operanionDate) < 30) {
            return redirect('/')->withErrors(['Мало времени на операцию, надо минимум 30 минут']);
        }

        // проверка на просроченные операции
        $overdue_operations = DB::table('defferred_operations')
            ->select(DB::raw('*'))
            ->whereRaw('timestamp(`operation_datetime`) < NOW()')
            ->where('operation_completed', false)
            ->get();
        if (count($overdue_operations)) {
            $request->session()->put('overdue_operations', 'есть просроченные операции!');
        } else {
            $request->session()->put('overdue_operations', '');
        }

        DB::transaction(function () use ($selectUser, $userTo, $summ, $operanionDate) {
            DB::table('defferred_operations')->insert([
                'user_id_from'        => $selectUser,
                'user_id_to'          => $userTo,
                'amount'              => $summ,
                'operation_datetime'  => $operanionDate,
                'operation_completed' => false,
            ]);
        });
        return redirect('/')->with('success', 'Операция запланирована');
    }
}
