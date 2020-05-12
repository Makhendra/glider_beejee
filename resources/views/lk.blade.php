@extends('layouts.app')

@section('content')
    @isset($user)
        <div class="row">
            <div class="col-6">
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
            <div class="col-6">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="card-body">
                            <h5 class="card-title">Статистика</h5>
                            @for($i = 0; $i < 5; $i++)
                                <div class="item-progress row">
                                    <div class="col-4">Название группы</div>
                                    <div class="col-8">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 15%"
                                                 aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 30%"
                                                 aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 20%"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
