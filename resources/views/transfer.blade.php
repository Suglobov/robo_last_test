<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">
    <ul uk-accordion>
        <li class="uk-open">
            <a class="uk-accordion-title" href="#">Отложенный перевод:</a>
            <div class="uk-accordion-content">
                <table class="uk-table uk-table-striped uk-table-small uk-table-middle">
                    <tr>
                        <th>Ваш id</th>
                        <th>Свободных средств</th>
                    </tr>
                    <tr>
                        <td>{{ $selectuser }}</td>
                        <th>{{ $userCurrent['amount'] - $userCurrent['deferred'] }}</th>
                    </tr>
                </table>
                <form id="operationForm"
                      class="uk-form-horizontal"
                      method="POST"
                      action="/defferred_operations">
                    {{ csrf_field() }}
                    <div class="uk-margin">
                        <label class="uk-form-label" for="select1">Кому переводим?</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="select1" name="user_id_to" required>
                                @foreach ($usersArr as $k => $user)
                                    @if($k != $selectuser)
                                        <option value="{{ $k }}">{{ $k }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="uk-margin"
                         uk-tooltip="title: Максимальная сумма: {{ $userCurrent['amount'] - $userCurrent['deferred'] }};">
                        <label class="uk-form-label" for="number1">Сумма перевода</label>
                        <div class="uk-form-controls">
                            <input class="uk-input"
                                   id="number1"
                                   type="number"
                                   name="summ"
                                   min="0"
                                   max="{{ $userCurrent['amount'] - $userCurrent['deferred'] }}"
                                   value="0"
                                   required
                            >
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="date1">Дата перевода</label>
                        <div class="uk-form-controls">
                            <div uk-form-custom="target: true">
                                <input class="uk-input"
                                       id="date1"
                                       type="datetime-local"
                                       name="date"
                                       {{--min="2017-06-01T08:30"--}}
                                       required
                                >
                            </div>
                        </div>
                    </div>
                    <input id="dateNow"
                           type="hidden"
                           name="datenow"
                           value=""
                           required
                    >
                    <div class="uk-margin">
                        <button class="uk-button uk-button-default">Перевод</button>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</div>
