@isset($table[0])
    @php if(isset($table[0]['not_use'])) {
        $table = array_map(function (&$item) {unset($item['not_use']);return $item;}, $table);
    };
    @endphp
    <div class="col-6">
        <table class="table table-bordered">
            <thead>
            <tr>
                @foreach($table[0] as $key => $row)
                    <th>{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($table as $key => $row)
                <tr>
                    @foreach($row as $k => $item)
                        <td>{{$item}}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endisset