@extends('layouts.app')

@section('seoVar')
    @php
        $seo = $activeGroup->seo ?? [];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            @isset($groups)
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <td class="table-active">
                            <a href="{{route('groups.main')}}">Все группы</a>
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
                @if($tasks->count() == 0)
                    <img src="{{asset('development.png')}}" alt="Раздел еще в разработке">
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Задача</th>
                            <th>Статистика</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>
                                    <a href="{{route('tasks.show', ['id' => $task->id])}}">{{$task->title}}</a>
                                </td>
                                <td><b>Успешно решено:</b> {{$task->successUserTask()->count()}} <br>
                                    <b>Взято подсказок:</b> {{$task->userTask->sum('hint_use')}}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                @endif
            @endisset
        </div>
    </div>
@endsection
