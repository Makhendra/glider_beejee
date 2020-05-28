@extends('layouts.app')

@section('content')
    @isset($user)
        <div class="row">
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Имя:</b> {{$user->name}}</li>
                            <li class="list-group-item"><b>Email:</b> {{$user->email}}</li>
                            @foreach($user->socialsAccount as $social)
                                <li class="list-group-item"><b>{{$social->provider}}: {{$social->provider_id}}</b></li>
                            @endforeach
                            <li class="list-group-item text-muted">Зарегистрирован {{$user->created_at}}</li>
                        </ul>
                        <div class="card-footer bg-transparent">
                            <a href="#" class="btn btn-primary">Сменить пароль</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="card-body">
                            <h5 class="card-title">Статистика</h5>
                            <span class="badge badge-primary" style="width: 10px">&nbsp;</span> Начаты <br>
                            <span class="badge badge-success" style="width: 10px">&nbsp;</span> Успешно решены <br>
                            <span class="badge badge-danger" style="width: 10px">&nbsp;</span> Взяты подсказки <br>
                            <hr>

                            @foreach($progress as $groupName => $progressUser)
                                <div class="d-flex flex-row mb-2 align-items-center">
                                    <div class="col-4">{{$groupName}}</div>
                                    <div class="col-8">
                                        <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{$progressUser['all']}}%"
                                                 aria-valuenow="{{$progressUser['all']}}" aria-valuemin="0" aria-valuemax="100">
                                                    {{$progressUser['all']}}%
                                                </div>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{$progressUser['success']}}%"
                                                 aria-valuenow="{{$progressUser['success']}}" aria-valuemin="0" aria-valuemax="100">
                                                 {{$progressUser['success']}}%
                                            </div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{$progressUser['wrong']}}%"
                                                 aria-valuenow="{{$progressUser['wrong']}}" aria-valuemin="0" aria-valuemax="100">
                                                {{$progressUser['wrong']}}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
