<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-alert-danger"
     @if(count($errors) === 0) hidden @endif>
    @foreach ($errors->all() as $er)
        <div>{{ $er }}</div>
    @endforeach
</div>
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="">
            <a class="uk-accordion-title" href="#">Список пользователей и их баланс:</a>
            <div class="uk-accordion-content">
                <table class="uk-table uk-table-striped uk-table-small uk-table-middle">
                    <tr>
                        <th>id</th>
                        <th>Средства на счете</th>
                        <th>Свободные средства</th>
                    </tr>
                    @foreach ($usersArr as $k => $user)
                        <tr>
                            <td>{{ $k }}</td>
                            <td>{{ $user['amount'] }}</td>
                            <td>{{ $user['amount'] - $user['deferred'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </li>
    </ul>
</div>
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="">
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
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="uk-open">
            <a class="uk-accordion-title" href="#">Выбрать пользователя:</a>
            <div class="uk-accordion-content">
                <form method="POST" action="/selectuser">
                    {{ csrf_field() }}
                    <div class="uk-margin">
                        <select class="uk-select" name="selectuser">
                            <option value="asfd">Не выбран</option>
                            @foreach ($usersArr as $k => $user)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-default">Мой выбор</button>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</div>
@if(Session::get('sectedUser'))
    <?php
    $selectuser = Session::get('sectedUser');
    $userCurrent = $usersArr[$selectuser];

    //    echo '<pre>';
    //    echo print_r($userCurrent, 1) . PHP_EOL;
    //    die();
    //    $userCurrent['available'] = $userCurrent['amount']
    ?>
    @include('transfer', [
        $selectuser,
        $userCurrent,
        $defferred_operations,
        $usersArr,
    ])
@endif
<?php //echo '<pre>'; print_r($user); die(); ?>
