@extends('layouts.app')

@section('content')
    <style>
        .hidden {
            display: none;
        }
    </style>
    <h1>{!! $data['title'] !!}</h1>
    <div class="row">

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">
                        {!! $data['task_text'] !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div id="decision">
                        <p class="card-text">
                            Для решения этой задачи необходимо:
                        <ol>
                            <li>Перевести в десятичную систему счисления числа из неравенства</li>
                            <li>Переписать неравенство и посчитать количество чисел</li>
                        </ol>
                        <form action="{{ route('tasks.check_answers', $data['slug']) }}" method="POST"
                              id="check_answer">
                            @csrf
                            <input type="hidden" name="number1" value="{!!  $data['number1'] !!}">
                            <input type="hidden" name="number2" value="{!!  $data['number2'] !!}">

                            <input type="hidden" name="scale_of_notation1" value="{!!  $data['scale_of_notation1'] !!}">
                            <input type="hidden" name="scale_of_notation2" value="{!!  $data['scale_of_notation2'] !!}">

                            <div class="input-group">
                                <input type="number" name="answer" id="answer" class="form-control"
                                       placeholder="Отправить ответ"/>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">
                                        На проверку
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="hidden" id="show_answer">
                        {!!  $data['number1'] !!}<sub>{!!  $data['scale_of_notation1'] !!}</sub>
                        = {!!  $data['format1']['text'] !!}
                        = {!!  $data['format1']['answer'] !!}<br>
                        {!!  $data['number2'] !!}<sub>{!!  $data['scale_of_notation2'] !!}</sub>
                        = {!!  $data['format2']['text'] !!}
                        = {!!  $data['format2']['answer'] !!}<br><br>

                        Теперь наше неравенство будет выглядеть так:
                        {!!  $data['format1']['answer'] !!} < x < {!!  $data['format2']['answer'] !!}

                        Следовательно, существует {!!  ($data['format2']['answer'] - $data['format1']['answer']) !!}
                        целых чисел, для
                        которых
                        это
                        неравенство выполнится. <br><br>

                        Ответ: {!!  ($data['format2']['answer'] - $data['format1']['answer']) !!} <br>

                        <div class="input-group">
                            <a href="{{ route('tasks.next', $data['slug']) }}">
                                <button class="btn btn-success">Попробовать снова</button>
                            </a>
                        </div>
                    </div>
                    <div id="decision_success" class="hidden">
                        <div class="alert alert-success">
                            Все верно
                        </div>
                        <a href="{{ route('tasks.next', $data['slug']) }}">
                            <div class="btn btn-success">
                                Следующий вариант
                            </div>
                        </a>
                    </div>
                    <div id="decision_error" class="hidden">
                        <div class="alert alert-danger">
                            Вы ошиблись
                        </div>
                        <div class="btn btn-warning"
                             onclick="document.getElementById('show_answer').classList.remove('hidden');document.getElementById('decision_error').classList.add('hidden')">
                            Показать решение
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
