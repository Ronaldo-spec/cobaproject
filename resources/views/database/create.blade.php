@extends('layout.datawarehouse')
<br><br>
<div class="container mt-5"> 
    {{-- {{ Breadcrumbs::render('payment_create') }}  --}}
    <div class="row justify-content-center align-items-center"> 
        <div class="card" style="width: 24rem;">
            <div class="card-header"> 
            <center>Tambah Tabel Pada database Mysql</center>  
            </div> 
            <div class="card-body"> 
                @if ($errors->any()) 
                <div class="alert alert-danger"> 
                    <strong>Whoops!</strong> There were some problems with your input.<br><br> 
                    <ul> 
                    @foreach ($errors->all() as $error) 
                    <li>{{ $error }}</li> 
                    @endforeach </ul> 
                </div> 
            @endif 
            <form method="post" action="{{ route('storetable') }}" id="myForm" enctype="multipart/form-data"> 
            @csrf 
                {{-- {{$data1 = array_combine($data,$pay)}} --}}
                {{-- @foreach (array_combine($data,$pay) as $d => $pay) --}}
                {{-- @foreach ($data as $key => $row) --}}
                @foreach ($data as $d)
                {{-- @if ($d['serviceType'] == 'Mysql' && $d['name'] != $pay->nama) --}}
                @if ($d['serviceType'] == 'Mysql')
                <input type='checkbox' value='{{$d['name']}}' name="nama[]" />
                <input type="hidden" name="tipe" value='{{$d['serviceType']}}'>
                <input type="hidden" name="layanan" value='{{$id}}'>
                <label for="{{$d['name']}}">{{ucfirst($d['name'])}}</label><br>
                @endif  
                {{-- @endforeach --}}
                @endforeach
                <br>
            <button type="submit" class="btn btn-primary">Submit</button> 
            </form> 
            </div> 
        </div> 
    </div> 
    </div> 
