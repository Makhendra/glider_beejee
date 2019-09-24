<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="meta">
    <title>{{ isset($title) ? $title : ($data['title'] ?? 'Авторизация')}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-fill">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if (Auth::id())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">
                            Главная
                        </a>
                    </li>
                </ul>
                @yield('back')
                <form class="form-inline" action="{{route('logout')}}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Выйти из аккаунта</button>
                </form>
            @endif
        </div>
    </nav>
    <div class="row mt-4 mb-2">
        <div class="col-12 text-center">
            <h1>{{  isset($title) ? $title :($data['title'] ?? 'Авторизация') }}</h1>
        </div>
    </div>
    @yield('content')

</div>
<footer>
    <script src="{{asset('js/app.js')}}"></script>
</footer>
</body>
</html>
