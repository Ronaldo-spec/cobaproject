@extends('database.core')
<br><br>
<script>
    {{$no = 0;}}
</script>
<div class="container mt-5"> 
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
            <form method="post" action="{{ route('payment.store') }}" id="myForm" enctype="multipart/form-data"> 
            @csrf 
                @foreach ($data as $d)
                @if ($d['serviceType'] == 'Mysql')
                <input type='checkbox' value='{{$d['name']}}' name="nama[]" />
                <input type="hidden" name="tipe" value='{{$d['serviceType']}}'>
                <input type="hidden" name="id" value='{{++$no}}'>
                <label for="{{$d['name']}}">{{ucfirst($d['name'])}}</label><br>
                @endif
                @endforeach
            <button type="submit" class="btn btn-primary">Submit</button> 
            </form> 
            </div> 
        </div> 
    </div> 
    </div> 
