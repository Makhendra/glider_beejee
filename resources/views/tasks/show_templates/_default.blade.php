@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('groups.index')}}">Все типы тренажеров</a></li>
                    <li class="breadcrumb-item"><a href="{{route('groups.tasks', $task->id)}}">{{$task->group->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$task->title}}</li>
                </ol>
            </nav>
        </div>
        <div class="{{$data['classLayout'] ?? 'col-md-4'}}">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">
                        {!! $data['task_text'] !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="{{$data['classLayout2'] ?? 'col-md-8'}}">
            <div class="card h-100">
                <div class="card-body">
                    <div id="decision">
                        <p class="card-text">
                            @yield('decision')
                        </p>
                        <form action="{{ route('tasks.check_answers', $data['slug']) }}" method="POST"
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
                    </div>
                    <div class="hidden" id="show_answer">
                        @yield('answer')
                        <div class="input-group">
                            <a href="{{ route('tasks.next', ['slug' => $data['slug'], 'success' => 0]) }}">
                                <button class="btn btn-success">Попробовать снова</button>
                            </a>
                        </div>
                    </div>
                    <div id="decision_success" class="hidden">
                        <div class="alert alert-success">
                            Все верно
                        </div>
                        <a href="{{ route('tasks.next', ['slug' => $data['slug'], 'success' => 1]) }}">
                            <div class="btn btn-success">
                                Следующий вариант
                            </div>
                        </a>
                    </div>
                    <div id="decision_error" class="hidden">
                        <div class="alert alert-danger">
                            Вы ошиблись. Вид ошибки: <div class="type-error">самая простая и распространенная - неизвестная</div>
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