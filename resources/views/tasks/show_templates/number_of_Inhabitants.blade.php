@extends('tasks.show_templates._default')

@section('user_task')
    <div class="row">
        @php
            $data['table1'] = [];
            $data['table2'] = [];
            if(isset($data['families'])) {
                $mothers = array_column($data['families'], 'mother');
                $fathers = array_column( $data['families'], 'father');
                $childrensList = array_column($data['families'], 'childrens');
                $childrens = [];
                foreach ($childrensList as $child) {
                    foreach ($child as $c) {
                        $childrens[] = $c;
                    }
                }
                $table = array_merge($mothers, $fathers, $childrens);
                shuffle($data['families']);
                $start = random_int(1, 500);
                foreach ($table as $people) {
                         $data['table1'][] = [
                        'id' => $start,
                        'Фамилия_И.О.' => "{$people['last_name']} {$people['name']} {$people['middlename']}",
                        'Пол' => $people['gender'],
                        'Год_рождения' => $people['year'],
                    ];
                    $start += 1;
                }
            }
        @endphp
        @include('components.table_database', ['table' => $data['table1'] ?? []])
        @include('components.table_database', ['table' => $data['table2'] ?? []])
    </div>
@endsection

@section('decision')
    Для решения этой задачи необходимо
@endsection

@section('form')

@endsection


@section('answer')

@endsection