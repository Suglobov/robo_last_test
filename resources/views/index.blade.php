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
</head>
<body>
<div class="uk-container">
    <?php
    $users = DB::table('users')->get();
    $tmp1 = DB::table('defferred_operations')
        ->select(DB::raw('sum(amount) as a, user_id_from'))
        ->groupBy('user_id_from')
        ->get();
    $defferred_operations = DB::table('defferred_operations')->get();

    $user_balance_op = [];
    foreach ($tmp1 as $i) {
        $user_balance_op[$i->user_id_from] = $i->a;
    }
    //    echo '<pre>' . print_r($user_balance_op, 1) . '</pre>';
    ?>

    <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
        <ul uk-accordion>
            <li class="uk-open">
                <a class="uk-accordion-title" href="#">Список пользователей и их баланс:</a>
                <div class="uk-accordion-content">
                    <table class="uk-table uk-table-striped uk-table-small uk-table-middle">
                        <tr>
                            <th>id</th>
                            <th>Средства на счете</th>
                            <th>Свободные средства</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->amount }}</td>
                                <td>
                                    @if (isset($user_balance_op[$user->id]))
                                        {{ $user->amount - $user_balance_op[$user->id] }}
                                    @else
                                        {{ $user->amount }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </li>
        </ul>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
        <ul uk-accordion>
            <li class="uk-open">
                <a class="uk-accordion-title" href="#">Список запланированных операций:</a>
                <div class="uk-accordion-content">
                    <table class="uk-table uk-table-striped uk-table-small uk-table-middle">
                        <tr>
                            <th>id</th>
                            <th>user_id_from</th>
                            <th>user_id_to</th>
                            <th>amount</th>
                            <th>operation_datetime</th>
                            <th>time_difference</th>
                            <th>operation_completed</th>
                        </tr>
                        @foreach ($defferred_operations as $op)
                            <tr>
                                <td>{{ $op->id }}</td>
                                <th>{{ $op->user_id_from }}</th>
                                <th>{{ $op->user_id_to }}</th>
                                <th>{{ $op->amount }}</th>
                                <th>{{ $op->operation_datetime }}</th>
                                <th>{{ $op->time_difference }}</th>
                                <th>{{ $op->operation_completed }}</th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </li>
        </ul>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
        <ul uk-accordion>
            <li class="uk-open">
                <a class="uk-accordion-title" href="#">Выбранный пользователь:</a>
                <div class="uk-accordion-content">
                    <div class="uk-margin">
                        <select class="uk-select" name="selectuser">
                            <option>Не выбран</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-default">Мой выбор</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
