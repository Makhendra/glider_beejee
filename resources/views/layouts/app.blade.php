<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="meta">
    <title>{{ isset($title) ? $title : ($data['title'] ?? 'Авторизация')}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css').'?ver='.date('dmy-h')}}">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-fill row">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if (Auth::id())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="{{route('groups.main')}}">
                            <img src="{{asset('logo3.png')}}" alt="">
                        </a>
                    </li>
                </ul>
                @yield('back')
                <a href="{{route('lk')}}" class="btn btn-outline-primary mr-3">Личный кабинет</a>
                <form class="form-inline" action="{{route('logout')}}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Выйти из аккаунта</button>
                </form>
            @endif
        </div>
    </nav>
    <div class="row mt-4 mb-2">
        @if (Auth::id())
            <div class="col-12 text-center">
                <h1>{{  isset($title) ? $title :($data['title'] ?? 'Авторизация') }}</h1>
            </div>
        @else
            <div class="col-4"><img src="{{asset('logo3.png')}}" alt=""></div>
            <div class="col-8 text-center">
                <h1>{{  isset($title) ? $title :($data['title'] ?? 'Авторизация') }}</h1>
            </div>
        @endif
    </div>
        @yield('content')
    </div>
    <footer class="container">
        <div class="text-center">
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reportAbug">
                Сообщить об ошибке
            </button>
        </div>

        <div class="modal fade" id="reportAbug" tabindex="-1" role="dialog" aria-labelledby="reportAbug"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('report_bug') }}" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Сообщить об ошибке</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="report">Сообщение об ошибке</label>
                                <textarea name="message" class="form-control" id="report" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Отправить</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </footer>
</body>
</html>
