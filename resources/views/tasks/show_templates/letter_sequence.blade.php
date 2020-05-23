@extends('tasks.show_templates._default')

@section('user_task')
    @php
        $image = session("image_$userTask->id");
        if(empty($image)) {
            $image = (new \App\Tasks\Graphs\Services\GraphImageService())->getImage($data['graph'], true);
            session(["image_$userTask->id" => $image]);
        }
    @endphp
    @include('components.image', [
    'img' => $image,
    'name' => 'Graph'
    ])
    @include('components.table_graph', ['graph' => $data['graph'], 'random_keys' => $data['random_keys'], 'aster' => '*'])
@endsection