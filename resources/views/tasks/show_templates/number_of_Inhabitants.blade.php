@extends('tasks.show_templates._default')

@section('user_task')
    <div class="row">
        @include('components.table_database', ['table' => \App\Models\CustomSession::getValue("table1_$userTask->id")])
        @include('components.table_database', ['table' => \App\Models\CustomSession::getValue("table2_$userTask->id")])
    </div>
@endsection
