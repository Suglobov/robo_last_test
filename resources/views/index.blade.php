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
    $users = DB::table('users')->get();
    $defferred_operations = DB::table('defferred_operations')->get();
    $tmp1 = DB::table('defferred_operations')
        ->select(DB::raw('sum(amount) as sum, user_id_from'))
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
    //    echo '<pre>';
    //    print_r($usersArr);
    //    die();
    ?>
    @include('content', [$errors, $users, $defferred_operations, $usersArr])
</div>
</body>
</html>
