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
    <div class="row mt-4">
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
