@php
    /** @var string $title */
    $metaTitle = $seo['meta_title'] ?? ($seo->meta_title ?? $title);
    $metaDescription = $seo['meta_description'] ?? ($seo->meta_description ?? '' );
    $metaKeywords = $seo['meta_keywords'] ?? ($seo->meta_keywords ?? '');
@endphp
<meta name="title" content="{{$metaTitle}}">
<meta name="description" content="{{$metaDescription}}">
<meta name="keywords" content="{{$metaKeywords}}">