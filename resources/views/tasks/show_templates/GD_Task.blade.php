@extends('tasks.show_templates._default')

@section('user_task')
    @include('components.image', ['img' => $data['image'], 'name' => 'Graph'])
    @include('components.table_graph', ['graph' => $data['graph']])
@endsection