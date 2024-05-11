@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit User</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('update-user/' . $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{ $user->name }}" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group mt-2">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ $user->email }}" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                        </div>

                        <div class="form-group mt-2">
                            <label for="exampleInputFoto">Foto</label>
                            <input type="file" class="form-control-file" id="exampleInputFoto" name="foto">
                            @if($user->foto)
                                <img src="{{ asset('storage/foto/' . $user->foto) }}" alt="Foto Pengguna" style="max-width: 100px;">
                            @else
                                Tidak Ada Foto
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
