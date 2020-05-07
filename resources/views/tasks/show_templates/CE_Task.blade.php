@extends('tasks.show_templates._default')

@section('decision')
    Для решения этой задачи необходимо:
    <ol>
        <li>Перевести в десятичную систему счисления числа из неравенства</li>
        <li>Переписать неравенство и посчитать количество чисел</li>
    </ol>
@endsection

@isset($data)
    @section('form')
        <input type="hidden" name="number1" value="{!!  $data['number1'] !!}">
        <input type="hidden" name="number2" value="{!!  $data['number2'] !!}">

        <input type="hidden" name="scale_of_notation1" value="{!!  $data['scale_of_notation1'] !!}">
        <input type="hidden" name="scale_of_notation2" value="{!!  $data['scale_of_notation2'] !!}">
    @endsection


    @section('answer')
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
    @endsection
@endisset