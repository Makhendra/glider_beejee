@extends('tasks.show_templates._default')

@section('user_task')
    @include('components.image', ['img' => \App\Models\CustomSession::getValue("image_$userTask->id"),'name' => 'Graph'])
    @include('components.table_graph', ['graph' => $data['graph'], 'random_keys' => $data['random_keys']])
@endsection