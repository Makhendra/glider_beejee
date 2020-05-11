@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @isset($groups)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Тип</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>
                                <a href="{{route('groups.tasks',  $group->id)}}">{{$group->name}}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endisset
        </div>
    </div>
@endsection