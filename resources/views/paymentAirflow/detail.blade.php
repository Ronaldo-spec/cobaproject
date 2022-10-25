@extends('layout.core')
@section('title','Detail Database')
<!DOCTYPE html>
<html>
{{-- @section('content')  --}}
<script>
    {{$no = 0;}}
</script>
<br><br>
<div class="container mt-5"> 
    <div class="row justify-content-center align-items-center"> 
        <div class="card" style="width: 60rem;"> 
            <div class="card-header"> 
            <center>Detail Tabel</center> 
            </div>
            <div class="card-body"> 
                <ul class="list-group list-group-flush"> 
                    <li class="list-group-item"><b>ID: </b>{{$data['id']}}</li> 
                    <li class="list-group-item"><b>Nama: </b>{{$data['name']}}</li> 
                    <li class="list-group-item"><b>Deskripsi: </b>{{$data['description']}}</li> 
                    <li class="list-group-item"><b>Versi: </b>{{$data['version']}}</li> 
                    <li class="list-group-item"><b>Tipe Service: </b>{{$data['serviceType']}}</li> 
                </ul> 
            </div> 

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Nama kolom</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['columns'] as $d)
                    <tr>    
                        <td scope="row">{{++$no}}</td>
                        <td>{{$d['name']}}</a></td>
                        <td>{{$d['dataType']}}</td>
                        <td>{{$d['description']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a class="btn btn-success mt-3" href="{{ route('payment.index') }}">Kembali</a> 
        </div> 
    </div> 
</div> 
</html>