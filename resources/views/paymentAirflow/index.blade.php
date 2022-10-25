@extends('layout.core')
<!DOCTYPE html>
<html>
<script>
    {{$no = 0;}}
</script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/app.css" rel="stylesheet">
    <title></title>
    
</head>
    <style>
        .link{
            color: black;
            text-decoration: none
        }
    </style>
<body>
    <br><br><br>
    <a class="btn btn-info" href="{{ route('payment.index') }}">Database</a>    
    <a class="btn btn-info" href="{{ route('paymentdw.index') }}">Data Warehouse</a>    
    <h1 style="text-align: center">Table Pipeline</h1>
    <div class="container-fluid">
        <p>Nama : {{$data['entity']['name']}}</p>
        <p>Type :{{$data['entity']['type']}}</p>
        <p>Deskripsi : {{$data['entity']['description']}}</p>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Nama Tabel</th>
                    <th scope="col">Tipe Service</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Versi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['nodes'] as $d)
                    {{-- @if (
                    $d['name'] == 'rekap_pelanggan' || 
                    $d['name'] == 'dim_tahun' || 
                    $d['name'] == 'fakta_pelanggan' ||
                    $d['name'] == 'dim_lokasi'
                    ) --}}
                        <tr>    
                            <td scope="row">{{++$no}}</td>
                            <td>{{$d['name']}}</td>
                            <td>{{$d['type']}}</td>
                            <td>{{$d['description']}}</td> 
                            {{-- <td>{{$d['version']}}</td> --}}
                            <td> 
        
                                {{-- <form action="{{ route('profil.destroy', $d->id) }}" method="POST">        --}}
                                {{-- <a class="btn btn-info" href="{{ route('payment.show', $d['fullyQualifiedName']) }}">Detail</a>                --}}
                                {{-- <a class="btn btn-info" href="{{ route('coba', $d['fullyQualifiedName']) }}">Schema</a>                --}}
                                {{-- <a class="btn btn-primary" href="{{ route('profil.edit', $d->id) }}">Edit</a>  --}}
                                
                                {{-- @csrf
                                @method('DELETE') 
                                <button type="submit" class="btn btn-danger">Delete</button> 
                                </form>  --}}
                            </td> 
                        </tr>
                    
                    {{-- @endif --}}
                @endforeach
            </tbody>
        </table>
        <h3 style="text-align: right">Total: {{$no}}</h3>

    </div>
</body>

</html>