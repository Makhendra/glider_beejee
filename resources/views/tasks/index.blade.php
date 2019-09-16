@extends('layouts.app')

@section('content')

    @isset($tasks)
        <table class="table">
            <thead>
            <tr>
                <th>Задача</th>
                <th>Текст задачи</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)

                <tr>
                    <td><a href="{{route('tasks.show', $task->id)}}">{{$task->title}}</a></td>
                    <td>{!! $task->task_text !!}</td>
                    <td></td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endisset

@endsection
