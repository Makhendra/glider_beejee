@php $id = $task->id ?? 1; $statuses = (new \App\Models\UserTask()); @endphp
@extends('layouts.app', ['title' => 'Задание '.$id])

@section('seoVar')
    @php
        $seo = $task->seo ?? [];
    @endphp
@endsection

@section('content')
    @isset($task)
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('groups.main')}}">Все типы тренажеров</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{route('groups.tasks', $task->group_id)}}">{{$task->group->name}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{$task->title}}</li>
                    </ol>
                </nav>
            </div>
            @if(empty($error))
                <div class="{{$classLayout ?? 'col-md-4'}}">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">
                                {!! $textUserTask !!}
                            </p>
                            @yield('user_task')
                        </div>
                    </div>
                </div>
                <div class="{{$classLayout2 ?? 'col-md-8'}}">
                    <div class="card h-100">
                        <div class="card-body">
                            <div id="decision">
                                @if($userTask->status == $statuses::INIT)
                                    <p class="card-text">
                                        {!! $task->decision !!}
                                    </p>
                                    <form action="{{ route('tasks.check_answers', $id) }}" method="POST"
                                          id="check_answer">
                                        @yield('form')
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="answer" id="answer" class="form-control"
                                                   placeholder="Отправить ответ" required/>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-success">
                                                    На проверку
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($userTask->status == $statuses::SUCCESS)
                                    <div id="decision_success">
                                        <div class="alert alert-success">
                                            Все верно
                                        </div>
                                        <a href="{{ route('tasks.next', ['id' => $id, 'success' => 1]) }}">
                                            <div class="btn btn-success">
                                                Следующий вариант
                                            </div>
                                        </a>
                                    </div>
                                @elseif($userTask->status == $statuses::WRONG and ! $userTask->hint_use)
                                    <div id="decision_error">
                                        <div class="alert alert-danger">
                                            Вы ошиблись. Вид ошибки:
                                            <div class="type-error">
                                                {{--                                        самая простая и распространенная - неизвестная--}}
                                            </div>
                                        </div>
                                        <a class="btn btn-warning"
                                           href="{{ route('tasks.get_solution', ['id' => $id]) }}">
                                            Показать решение
                                        </a>
                                        <a href="{{ route('tasks.next', ['id' => $id]) }}">
                                            <button class="btn btn-danger">Следующее задание</button>
                                        </a>
                                    </div>
                                @endif

                                @if($userTask->hint_use)
                                    @isset($formatAnswer)
                                        <div id="show_answer">
                                            {!! $formatAnswer !!}
                                            <div class="input-group">
                                                <a href="{{ route('tasks.next', ['id' => $id]) }}">
                                                    <button class="btn btn-success">Попробовать снова</button>
                                                </a>
                                            </div>
                                        </div>
                                    @endisset
                                @endif

                            </div>

                        </div>
                    </div>
                    @else
                        <div class="col-md-12 text-center mb-5">
                            <h2>Упс, что-то пошло не так</h2>
                            <a href="{{route('groups.main')}}">Вернуться на главную</a>
                        </div>
                    @endif
                </div>
    @endisset
@endsection