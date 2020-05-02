@isset($img)
    @php $id = random_int(1, 2000); @endphp
    <a href="javascript:;"
       class="fancybox-selector"
       data-src="#{{$name ?: $id}}"
       data-caption="{{$name ?: $id}}"
    >
        <img class="img-fluid image" src="data:image/png;charset=utf-8;base64,{{$img}}" alt="{{$name ?: $id}}"/>
    </a>
    <img id="{{$name ?: $id}}" class="img-fluid image" src="data:image/png;charset=utf-8;base64,{{$img}}"
         alt="Big_{{$name ?: $id}}" style="display: none;height: 1000px;" />
@endisset