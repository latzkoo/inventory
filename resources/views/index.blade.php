<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<title>@isset($meta){{ $meta->getTitle() }}@else {{ config('app.name') }}@endisset</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
<link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
<link rel="icon" type="image/png" href="{{ config('app.url') }}/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="{{ config('app.url') }}/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="{{ config('app.url') }}/favicon-96x96.png" sizes="96x96">
</head>

<body>
@include('layouts.header')
@yield('content')
@include('layouts.footer')
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
