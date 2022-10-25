<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crud Application</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine-ie11.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>

    <script>
    {{$no = 0;}}
</script>
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
        <a class="btn btn-outline-light bg-primary" href="{{ route('database.data', lcfirst($nama) )}}">Database</a>&nbsp;
        <a class="btn btn-light" href="{{ route('warehouse.data', lcfirst($nama)) }}">Data Warehouse</a> &nbsp;
        <a class="btn btn-light" href="{{ route('paymentairflow.index') }}">Airflow</a>
        @foreach ($pro as $p)
        <a class="btn btn-success position-absolute end-0"href="{{ route('database.addtable', $p->nama) }}"> Add Table</a>
        @endforeach
        <br><br>
        <div class="container-fluid">
         <div class="row">
            <div class="col-md-4">

            <select id="gr" class="form-control">
                <option>Pilih Layanan...</option>
                @foreach ($heleh as $gr)
                <option value="{{$gr->id_program}}">{{ $gr->nama}}</option>
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
                        @if ( $d['name'] == $p->nama && $p->tipeservice == 'Mysql' && $p->layanan == $pro->nama)
                        <tr>
                            <td scope="row">{{++$no}}</td>
                            <td>{{$d['name']}}</td>
                            <td>{{$d['serviceType']}}</td>
                            <td>{{$d['description']}}</td>
                            <td>{{$d['version']}}</td>
                            <td>
                                <form action="{{ route('database.destroy', $p->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('database.show', $d['fullyQualifiedName']) }}">Detail</a>
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

    <script>
        $('#heleh').change(function() {
            var id_program = $(this).val();
            if (id_program) {
                $.ajax({
                    type:"GET",
                    url:"/getProgram?id_program="+id_program,
                    dataType: 'JSON',
                    success:function(res){}
                })
            } else {
                $("#heleh").empty();
            }
        });

    </script>


</body>

</html>
