<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crud Application</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine-ie11.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            .navbar-brand{
            color: #219F94;
            padding: 7px;
            }
            /* .active{
              background:#219F94;
              overflow:hidden;
              padding:7px;
              border-radius: 64px;
              color: #ffffff;
            }
            a:hover{
              background:#219F94;
              border-radius: 64px;
              color: #ffffff;
            }        */
        </style>  
</head>

<body>
<nav class="navbar bg-white fixed-top">
  <div class="container-fluid">
  <b class="navbar-brand" href="#">
      {{-- <img src="images/Capture.PNG" alt="" width="80" style="margin-left:30% ;" style="padding:0 ;"> --}}
          </b>
    <a class="navbar-brand @yield('index')" href="/program">Program</a>
    <a class="navbar-brand @yield('tanaman')" href="/schema">Schema</a>
    <a class="navbar-brand @yield('budidaya')" href="/table">Table</a>
    <a class="navbar-brand @yield('media')" href="/media">DW</a>
    <form class="d-flex">
      <input class="form-control me-2" type="text" placeholder="Cari berdasarkan nama.." name="search"  aria-label="Search" style="border-radius: 20px;" style="padding-top: 50px;">
      <button class="btn btn-outline-success" type="button" style="border-radius: 20px;">Search</button>
    </form>
  </div>
</nav>

@yield('contents')

</body>
