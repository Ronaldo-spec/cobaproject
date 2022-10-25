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
    <h1 style="text-align: center">Schema</h1>
    <div class="container-fluid">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Nama Database</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>    
                    <td scope="row">{{++$no}}</td>
                    <td><a class="link" href="/database/db{{$no}}">{{$d['name']}}</a></td>
                    <td>{{$d['serviceType']}}</td>
                    <td>{{$d['description']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h3 style="text-align: right">Total: {{$no}}</h3>  
    </div>
</body>

</html>