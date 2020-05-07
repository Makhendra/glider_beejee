<table class="table table-bordered">
    @foreach($graph as $key => $row)
        @if ($key == 0)
            @php
                $first = ['-'];
                array_walk($graph, function ($item, $key) use (&$first) {
                    $l = 'П' . ($key + 1);
                    array_push($first, $l);
                });
                foreach($first as $k => $item) {
                    echo '<td>'.$item.'</td>';
                }
            @endphp
        @endif
        @php array_unshift($row, 'П' . ($key + 1)); @endphp
        <tr>
            @foreach($row as $k => $item)
                <td>{{$item}}</td>
            @endforeach
        </tr>
    @endforeach
</table>
