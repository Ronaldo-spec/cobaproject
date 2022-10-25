@extends('layout.core')
@section('title','Detail Program')
<!DOCTYPE html>
<html>
{{-- @section('content')  --}}
<br><br><br><br>
<div class="container mt-5"> 
    {{-- {{ Breadcrumbs::render('detail_program', $pro) }} --}}
    <div class="row justify-content-center align-items-center"> 
        <div class="card" style="width: 24rem;"> 
            <div class="card-header"> 
            <center>Detail Program</center> 
            </div>
            <div class="card-body"> 
                <ul class="list-group list-group-flush"> 
                    <li class="list-group-item"><b>Id: </b>{{$pro->id_program}}</li> 
                    <li class="list-group-item"><b>Nama: </b>{{$pro->nama}}</li> 
                    <li class="list-group-item"><b>Deskripsi: </b>{{$pro->deskripsi}}</li>
                    @if ($pro->image)
                    <li class="list-group-item"><b>ERD: </b><img width="300px" src="{{asset('storage/'.$pro->image)}}"></li>
                    @else
                    <li class="list-group-item"><b>ERD: </b>{{"-"}}</li>
                    @endif
                </ul> 
            </div> 
            <a class="btn btn-success mt-3" href="{{ route('program.index') }}">Kembali</a> 
        </div> 
    </div> 
</div> 
</html>