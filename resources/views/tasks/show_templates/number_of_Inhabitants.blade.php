@extends('tasks.show_templates._default')

@section('user_task')
    <div class="row">
        <div class="col-8">
        @include('components.table_database', ['table' => \App\Models\CustomSession::getValue("table1_$userTask->id")])
        </div>
        <div class="col-4">
        @include('components.table_database', ['table' => \App\Models\CustomSession::getValue("table2_$userTask->id")])
        </div>
    </div>
@endsection
