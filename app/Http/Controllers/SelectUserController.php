<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectUserController extends Controller
{
    public function selectUser(Request $request)
    {
        $this->validate($request, [
            'selectuser' => 'required|integer',
        ], [
            'неверный id пользователя',
        ]);

        $users = DB::table('users')->get()->toArray();
        $selectUser = $request->input('selectuser');
        $selectUserFromDb = collect($users)
            ->filter(function ($value, $key) use ($selectUser) {
                return $value->id == $selectUser;
            });
//        echo '<pre>';
//        echo print_r(count($selectUserFromDb), 1);
        if ($selectUser && count($selectUserFromDb) > 0) {
            $request->session()->put('sectedUser', $selectUser);
        } else {
            $request->session()->put('sectedUser', '');
        }

        return redirect('/');
    }
}
