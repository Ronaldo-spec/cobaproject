@extends('layout.core')
<!DOCTYPE html>
<html>
<script>
    {{$no = 0;}}
</script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link href="/css/app.css" rel="stylesheet"> --}}
    <title></title>
    
</head>
    <style>
        .link{
            color: black;
            text-decoration: none
        }
    </style>
    <br><br><br><br>
    <div class="mx-auto pull-right">
        <div class="float-left">
            <form action="{{ route('program.index') }}" method="GET" role="search">
                <div class="input-group">
                    {{-- <input type="text" class="form-control mr-2" name="term" placeholder="Search Nama User" id="term"> --}}
                    <a href="{{ route('program.index') }}" class=" mt-1">
                        <span class="input-group-btn"> 
                        
                            <div class="float-right my-2"> 
                                    {{-- <button class="btn btn-info" type="submit" title="Search User">
                                        <span class="fas fa-search">Search</span>
                                    </button>    --}}
                                <a class="btn btn-success" href="{{ route('program.create') }}"> Input User</a>
                            </div>
                        </span>
                    </a>
                </div>
            </form>
        </div>
    </div>

<body>
    <h1 style="text-align: center">Program</h1>
    {{ Breadcrumbs::render('program') }}
    <div class="container-fluid">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    {{-- <th scope="col">NO</th> --}}
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskirpsi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pro as $d)
                <tr>    
                    <td scope="row">{{++$no}}</td>
                    <td>{{ $d->nama }}</td> 
                    <td>{{ $d->deskripsi }}</td> 
                    <td> 

                        <form action="{{ route('program.destroy', $d->id_program) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('database.data', lcfirst($d->nama)) }}">Tabel</a>               
                        <a class="btn btn-info" href="{{ route('program.show', lcfirst($d->id_program)) }}">Detail</a>               
                        <a class="btn btn-primary" href="{{ route('program.edit', $d->id_program) }}">Edit</a> 
                        
                        @csrf
                        @method('DELETE') 
                        <button type="submit" class="btn btn-danger">Delete</button> 
                        </form> 
                    </td> 
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <h3 class="text-center" style="color: red;" >Maaf Pencarian Data Kosong</h3>
                    </td>
                </tr>
                @endforelse
         
            </tbody>
        </table>
        <h3 style="text-align: right">Total: {{$no}}</h3>  
    </div>
</body>

</html>