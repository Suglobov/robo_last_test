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

        // проверим сумму, если 0 - ничего не делаем
        if ($summ == 0) {
            return redirect('/');
        }
        $selectUserFromDb = array_values($selectUserFromDb);
        $deferredDB = DB::table('defferred_operations')
            ->select(DB::raw('sum(amount) as sum, user_id_from'))
            ->where('user_id_from', $selectUserFromDb[0]->id)
            ->groupBy('user_id_from')
            ->get();
        $deferred = count($deferredDB) === 0 ? 0 : $deferredDB[0]->sum;
        $available = $selectUserFromDb[0]->amount - $deferred;
        //        print_r($available);

        // проверка суммы на доспустимое значение
        if ($available < $summ) {
            return redirect('/')->withErrors(['Сумма превышает допустимое значение']);
        }

        //        $operationDate = \DateTime::createFromFormat(
        //            'Y-m-dTH:i:s',
        //            $request->input('date'));
        echo '<pre>';
        $serverDate = new Carbon();
        $userDate = new Carbon($dateNow);
        $diffHoursDate = $userDate->diffInHours($serverDate, false);

        $operanionDate = new Carbon($date);
        echo '$operanionDate before: ' . print_r($operanionDate, 1). PHP_EOL;
        $operanionDate->addHour($diffHoursDate);
        echo '$operanionDate after: ' . print_r($operanionDate, 1). PHP_EOL;

        echo '$userDate: ' . print_r($userDate, 1). PHP_EOL;
        echo '$serverDate: ' . print_r($serverDate, 1). PHP_EOL;
        echo '$diffHoursDate: ' . print_r($diffHoursDate, 1). PHP_EOL;


        //        $date1 = \DateTime::createFromFormat('j-M-Y', '15-Feb-2009')->format('Y-m-d');
        //        echo $date1;
        //        print_r($operationDate->format('Y-m-dTH:i:s'));
    }
}
