@extends('layouts.static')
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @yield('common_meta')
    @yield('common_css')
    @yield('app_css')
    @yield('common_js_header')
</head>
<body lang="{{Lang::getLocale()}}">
@yield('common_js_config')
@yield('front_header')

@yield('front_left')
@yield('content')
@yield('common_js_footer')
@yield('app_js')
</body>
</html>