@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @isset($groups)
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <td class="table-active">
                            <a href="{{route('groups.index')}}">Все группы</a>
                        </td>
                    </tr>
                    @foreach($groups as $group)
                        <tr>
                            <td class="{{$group_id == $group->id ? 'table-success': ''}}">
                                <a href="{{route('groups.tasks',  $group->id)}}">{{$group->name}}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endisset
        </div>

        <div class="col-md-9">
            @isset($tasks)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Задача</th>
                        <th>Текст задачи</th>
                        <th>Статистика</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>
                                <a href="{{route('tasks.show', ['id' => $task->id])}}">{{$task->title}}</a>
                            </td>
                            <td>{!! $task->task_text !!}</td>
                            <td><b>Успешно решено:</b> {{$task->userTask->sum('status')}} <br>
                                <b>Взято подсказок:</b> {{$task->userTask->sum('hint_use')}}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @endisset
        </div>
    </div>
@endsection
