@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Daftar User</div>
                
                <div class="card-body">
                    <form method="POST"  action="{{ url('store-user') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
                            
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                            
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                        </div>

                        <form method="POST"  action="{{ url('store-user') }}" enctype="multipart/form-data" id="userForm">
                            @csrf
                            
                        <div class="form-group mt-2">
                        
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <label for="exampleInputFoto">Foto</label>
                            <input type="file" class="form-control-file" id="exampleInputFoto" name="foto">
                        </div>
                       
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>

                        
                    </form>
                </div>
            </div>
        </div>
       
        
    </div>
</div>
<script type="text/javascript" class="init">
	

$(document).ready(function () {
	var table = $('#example').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );

    $("#userForm").submit(function () {
            // Optionally, you can add a loading indicator or other UI feedback here
            location.reload();
        });
});

</script>

@endsection



