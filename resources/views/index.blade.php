<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/css/uikit.min.css"/>

    <!-- UIkit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit-icons.min.js"></script>

    <script src="{{ asset('js/app.js ') }}"></script>
</head>
<body>
<div class="uk-container">
    <?php
    $serverDate = new Carbon\Carbon();
    $users = DB::table('users')->get();
    $errorsFromDb = DB::table('errors_defferred_operations')->get();
    $defferred_operations = DB::table('defferred_operations')
        ->where('operation_completed', false)
        ->orderBy('operation_datetime')
        ->get();
    $tmp1 = DB::table('defferred_operations')
        ->select(DB::raw('sum(amount) as sum, user_id_from'))
        ->where('operation_completed', false)
        ->groupBy('user_id_from')
        ->get();
    $tmp2 = [];
    foreach ($tmp1 as $i) {
        $tmp2[$i->user_id_from] = $i->sum;
    }
    $usersArr = [];
    foreach ($users as $i) {
        if (isset($tmp2[$i->id])) {
            $usersArr[$i->id] = [
                'deferred' => $tmp2[$i->id],
            ];
        } else {
            $usersArr[$i->id] = [
                'deferred' => 0,
            ];
        }
        $usersArr[$i->id]['amount'] = $i->amount;
    }

    $usersWithOneLastOp = DB::select(
        'SELECT
            u.id AS user_id
          , u.amount AS user_amount
          , d.id
          , d.user_id_from
          , d.user_id_to
          , d.amount
          , d.operation_datetime
          , d.operation_completed
         FROM users AS u
         LEFT JOIN defferred_operations AS d
          ON d.user_id_from = u.id
          AND d.id = (
             SELECT MAX(d_max.id)
             FROM defferred_operations AS d_max
             WHERE d_max.user_id_from = u.id
          )'
    );
    //    echo '<pre>';
    //    print_r(new \Date());
    //    die();
    ?>
    @include('content', [$errorsFromDb, $users, $defferred_operations, $usersArr, $usersWithOneLastOp, $serverDate])
</div>
</body>
</html>
