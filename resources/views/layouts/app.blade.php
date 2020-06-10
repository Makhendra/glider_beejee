<!DOCTYPE html>
<html lang="ru">
<head>
    @php $title = isset($title) ? $title : ($data['title'] ?? 'Авторизация'); @endphp
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="meta">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css').'?ver='.date('dmy-h')}}">
    <link href="{{request()->url()}}" rel="canonical">
    @yield('seoVar')
    @include('components.seo')
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-fill text-lg-center">
        <a class="navbar-brand mobile-logo d-inline-block {{Auth::id() ? '' : 'logo-full'}}" href="{{route('groups.main')}}">
            <img src="{{asset('logo3.png')}}" alt="">
        </a>
        @if (Auth::id())
            <button class="navbar-toggler d-inline-block d-lg-none" type="button"
                    data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
                @yield('back')
                <form class="form-inline" action="{{route('logout')}}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Выйти из аккаунта</button>
                </form>
                <a href="{{route('lk')}}" class="btn btn-outline-primary mr-3">Личный кабинет</a>
            </div>
        @endif
    </nav>
    @if (Auth::id())
        <div class="row mt-4 mb-2">
            <div class="col-12 text-center">
                <h1>{{ $title }}</h1>
            </div>

        </div>
    @endif
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
                        <input type="hidden" name="url" value="{{url()->current()}}">
                        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleInputEmail1"
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
