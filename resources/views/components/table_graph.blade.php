<table class="table table-bordered">
    @php $j = 1;@endphp
    @foreach($random_keys as $k => $char)
        @if ($k == 0)
            @php
                $first = ['-'];
                $i = 0;
                array_walk($graph, function () use (&$first, &$i) {
                    $l = 'П' . ($i + 1);
                    array_push($first, $l);
                    $i += 1;
                });
                foreach($first as $k => $item) {
                    echo '<td>'.$item.'</td>';
                }
            @endphp
        @endif
        <tr>
            <td>П{{$j}}</td>
            @foreach($random_keys as $k => $item)
                @if(isset($aster))
                    <td>{{ isset($graph[$char][$item]) ? $aster:  0}}</td>
                @else
                    <td>{{$graph[$char][$item] ?? 0}}</td>
                @endif
            @endforeach
        </tr>
        @php $j += 1; @endphp
    @endforeach
</table>
