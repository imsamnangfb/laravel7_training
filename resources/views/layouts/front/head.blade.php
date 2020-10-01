<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>@yield('pagetitle','Master Page')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<!-- Font -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
	<!-- Stylesheets -->
    <link href="{{ asset('frontend/common-css/bootstrap.css') }}" rel="stylesheet">
    @stack('css')
	<link href="{{ asset('frontend/common-css/ionicons.css') }}" rel="stylesheet">
</head>
