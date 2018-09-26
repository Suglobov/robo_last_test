<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-alert-danger"
     @if(count($errors) === 0) hidden @endif>
    @foreach ($errors->all() as $er)
        <div>{{ $er }}</div>
    @endforeach
</div>
<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-alert-success"
     @if(!session('success')) hidden @endif>
    <div>{{ session('success') }}</div>
</div>
<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-alert-warning"
     @if(!session('overdue_operations')) hidden @endif>
    <div>{{ session('overdue_operations') }}</div>
</div>
<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-alert-danger"
     @if(!count($errorsFromDb)) hidden @endif>
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-text-nowrap">
            <tr>
                <th>id ошибки</th>
                <th>id ошибочной операции</th>
                <th>дата</th>
                <th>сообщение</th>
            </tr>
            @foreach ($errorsFromDb as $erDb)
                <tr>
                    <th>{{ $erDb->id }}</th>
                    <th>{{ $erDb->defferred_operations_id }}</th>
                    <th>{{ $erDb->date }}</th>
                    <th>{{ $erDb->message }}</th>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="">
            <a class="uk-accordion-title" href="#">Список пользователей и их последней операции:</a>
            <div class="uk-accordion-content">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-text-nowrap">
                        <tr>
                            <th>id пользователя</th>
                            <th>средства на счете</th>
                            <th>id операции</th>
                            <th>id пользователя от</th>
                            <th>id пользователя к</th>
                            <th>сумма операции</th>
                            <th>дата операции</th>
                            <th>завершена операция</th>
                        </tr>
                        @foreach ($usersWithOneLastOp as $k => $us)
                            <tr>
                                <th>{{ $us->user_id }}</th>
                                <th>{{ $us->user_amount }}</th>
                                <th>{{ $us->id }}</th>
                                <th>{{ $us->user_id_from }}</th>
                                <th>{{ $us->user_id_to }}</th>
                                <th>{{ $us->amount }}</th>
                                <th>{{ $us->operation_datetime }}</th>
                                <th>{{ $us->operation_completed }}</th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="">
            <a class="uk-accordion-title" href="#">Список пользователей и их баланс:</a>
            <div class="uk-accordion-content">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-text-nowrap">
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
            </div>
        </li>
    </ul>
</div>
<div class="uk-margin-bottom">
    Время на сервере: <span id="serveDate">{{ $serverDate }}</span>
</div>
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="">
            <a class="uk-accordion-title" href="#">Список запланированных операций:</a>
            <div class="uk-accordion-content">
                <div class="parent_defferred_operations uk-overflow-auto">
                    @if (count($defferred_operations) < 1)
                        <div>Список пуст</div>
                    @endif
                    <div class="help_text uk-text-primary"></div>
                    <table class="table_defferred_operations uk-table uk-table-striped uk-table-small uk-table-middle uk-text-nowrap">
                        <tr>
                            <th>id</th>
                            <th>user_id_from</th>
                            <th>user_id_to</th>
                            <th>amount</th>
                            <th>operation_datetime</th>
                            <th>operation_completed</th>
                        </tr>
                        @foreach ($defferred_operations as $do)
                            <tr>
                                <td>{{ $do->id }}</td>
                                <th>{{ $do->user_id_from }}</th>
                                <th>{{ $do->user_id_to }}</th>
                                <th>{{ $do->amount }}</th>
                                <th class="operation_datetime">{{ $do->operation_datetime }}</th>
                                <th>{{ $do->operation_completed }}</th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="">
            <a class="uk-accordion-title" href="#">Выбрать пользователя:</a>
            <div class="uk-accordion-content">
                @if(Session::get('sectedUser'))
                    <div>Сейчас выбран id: {{ Session::get('sectedUser') }}</div>
                @endif
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
                        <button class="uk-button uk-button-primary">Мой выбор</button>
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
    ?>
    @include('transfer', [
        $selectuser,
        $userCurrent,
        $defferred_operations,
        $usersArr,
    ])
@endif
