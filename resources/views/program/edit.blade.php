@extends('layout.core')
<br><br><br>
<div class="container mt-5"> 
    <div class="row justify-content-center align-items-center"> 
        <div class="card" style="width: 24rem;"> 
            <div class="card-header"> 
            Edit User
            </div> 
            <div class="card-body"> 
                @if ($errors->any()) 
                <div class="alert alert-danger"> 
                    <strong>Whoops!</strong> There were some problems with your input.<br><br> 
                    <ul> 
                        @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                        @endforeach 
                    </ul> 
                </div>
            @endif 
            <form method="post" action="{{ route('program.update', $pro->id_program) }}" id="myForm" enctype="multipart/form-data"> 
            @csrf 
            @method('PUT')
                {{-- <div class="form-group"> 
                    <label for="id_program">Id</label> 
                    <input type="text" name="id_program" class="form-control" id="id_program" value="{{ $pro->id_program }}" aria-describedby="id_program" > 
                </div>  --}}
                <div class="form-group"> 
                    <label for="nama">Nama</label> 
                    <input type="text" name="nama" class="form-control" id="nama" value="{{ $pro->nama }}" aria-describedby="nama" > 
                </div> 
                <div class="form-group"> 
                    <label for="deskripsi">Deskripsi</label> 
                    <input type="username" name="deskripsi" class="form-control" id="deskripsi" value="{{ $pro->deskripsi }}" aria-describedby="deskripsi" >
                <div class="mb-3">
                    <label for="image" class="form-label">Image ERD</label>
                    <input class="form-control" @error('image') is-invalid @enderror type="file" id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div> 
            <button type="submit" class="btn btn-primary">Submit</button> 
            </form> 
        </div> 
    </div> 
</div> 
</div> 
