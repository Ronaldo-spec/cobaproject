@extends('layout.datawarehouse')
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
    {{-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"> --}}
    <h1 style="text-align: center">Table Layanan {{$nama}}</h1>
        <table class="table table-bordered" id="myTable">
        <!-- <button type="button" class="btn btn-primary active" data-bs-toggle="button" aria-pressed="true">Active toggle button</button -->




        <a class="btn btn-light" href="{{ route('program.index') }}">Program</a> &nbsp;
        <a class="btn btn-light" href="{{ route('database.show', lcfirst($nama) )}}">Database</a>&nbsp;
        <a class="btn btn-outline-light bg-primary" href="{{ route('warehouse.show', lcfirst($nama)) }}">Data Warehouse</a> &nbsp;
        <a class="btn btn-light" href="{{ route('paymentairflow.index') }}">Airflow</a>
        @foreach ($pro as $p)
        <a class="btn btn-success position-absolute end-0"href="{{ route('warehouse.addtable', $p->nama) }}"> Add Table</a>
        @endforeach
        <br><br>
        <div class="container-fluid">
         <div class="row">
            <div class="col-md-4">

            


            {{-- <select id="filter-layanan" class="form-control"  input-sm>
                <option>Pilih Layanan...</option>
                @foreach ($coba as $ca)
                <option value="{{ $ca->id_program }}" {{$cobaja->id_program == $ca->id_program  ? 'selected' : ''}}>{{ $ca->nama}}</option>
                @endforeach
            </select> --}}

             <select id="filter-database" class="form-control" input-sm> 
                <option>Layanan</option>
                @foreach($coba as $cb)
                <option value="{{$cb->id_program}}" @if($cobaja->id_program == $cb->id_program) selected @endif">{{$cb->nama}}</option>
                @endforeach
                </select> 
            </div>
            </div>

    {{-- {{ Breadcrumbs::render('payment') }} --}}
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
                @foreach ($pro as $pro)
                    @foreach ($pay as $p)
                        @foreach ($data as $d)
                        @if ( $d['name'] == $p->nama && $p->tipeservice == 'Clickhouse' && $p->layanan == $pro->nama)
                        <tr>
                            <td scope="row">{{++$no}}</td>
                            <td>{{$d['name']}}</td>
                            <td>{{$d['serviceType']}}</td>
                            <td>{{$d['description']}}</td>
                            <td>{{$d['version']}}</td>
                            <td>
                                <form action="{{ route('warehouse.destroy', $p->id) }}" method="POST">       
                                <a class="btn btn-info" href="{{ route('warehouse.show', $d['fullyQualifiedName']) }}">Detail</a>
                                {{-- <a class="btn btn-info" href="{{ route('coba', $d['fullyQualifiedName']) }}">Schema</a>                --}}
                                {{-- <a class="btn btn-primary" href="{{ route('profil.edit', $d->id) }}">Edit</a>  --}}

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                                </form> 
                            </td>
                        </tr>

                        @endif
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <h3 style="text-align: right">Total: {{$no}}</h3>

    </div>


</body>

</html>
