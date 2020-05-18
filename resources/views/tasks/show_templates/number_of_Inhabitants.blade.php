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
                shuffle($table);
                $start = random_int(1, 500);
                foreach ($table as $key => $people) {
                    $data['table1'][] = [
                        'id' => $start,
                        'Фамилия_И.О.' => "{$people['last_name']} {$people['name']} {$people['middlename']}",
                        'Пол' => $people['gender'],
                        'Год_рождения' => $people['year'],
                        'not_use' => $people
                    ];
                    if(!$people['is_parent']) {
                        $data['table2'][] = [
                            'ID_Родителя' => 'Ж',
                            'ID_Ребёнка' => $start,
                            'not_use' => $people
                        ];
                        $data['table2'][] = [
                            'ID_Родителя' => 'М',
                            'ID_Ребёнка' => $start,
                            'not_use' => $people,
                        ];
                    }
                    $start += 1;
                }
                foreach ($data['table2'] as $key => &$item) {
                    if(in_array( $item['ID_Родителя'] , ['М', 'Ж'])) {
                        $parentL = array_filter($data['table1'], function ($element) use ($item) {
                            $family_id = $element['not_use']['family_id'] == $item['not_use']['family_id'];
                            $gender = $element['not_use']['gender'] == $item['ID_Родителя'];
                            $is_parent = $element['not_use']['is_parent'];
                            return $family_id && $gender && $is_parent;
                        });
                        $parent = array_shift($parentL);
                        if(isset($parent['id'])) {
                            $item['ID_Родителя'] = $parent['id'];
                        } else {
                            unset($data['table2'][$key]);
                        }
                    }
                }
                shuffle($data['table2']);
            };
        @endphp
        @include('components.table_database', ['table' => $data['table1'] ?? []])
        @include('components.table_database', ['table' => $data['table2'] ?? []])
    </div>
@endsection
