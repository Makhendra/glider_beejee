@extends('tasks.show_templates._default')

@section('decision')
    Для решения этой задачи необходимо: <br>

    <ul>
        <li>Представляем нужное число, к примеру 2000, где 2 - это нужная нам буква</li>
        <li>Переведем необходимо число из системы исчисления(количество букв в алфавите) в 10</li>
        <li>Не забудем о том, что есть слово номер 1, записывающееся как 0, а значит, нужно прибавить 1</li>
    </ul>
@endsection

@section('form')
    @php
        $count_chars = $data['count_chars'] ?? 0;
        $count_letters = $data['count_letters'] ?? 0;
        $allCountWords = pow($count_chars, $count_letters);
    @endphp
    <input type="hidden" name="count_chars" value="{{ $count_chars }}">
    <input type="hidden" name="count_letters" value="{{ $count_letters }}">
    <input type="hidden" name="all_count_word" value="{{ $allCountWords }}">
@endsection

@section('answer')
    Из {{ $count_chars }} букв можно составить
    {{ $count_chars }}<sup>{{ $count_letters }}</sup> = {{$allCountWords }} {{trans_choice($count_chars, ['трёхбуквенных','четырёхбуквенных', 'пятибуквенных'])}}  слов. <br>
    Т. к. слова идут в алфавитном порядке,
    то первая одна пятая часть букв (125 шт) начинаются с «И», <br>
    вторая часть (тоже 125) – с «К»,
    третья — с «Н», четвёртая — с «О»,
    последняя — с «Т» то есть первая буква меняется через 125 слов.
    <br>
    Т. е. со слова с номером 376 первой буквой будет О.
@endsection