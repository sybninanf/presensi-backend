@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="{{ url('create-user') }}" type="button" class="btn btn-info mb-2">+ Tambah User</a>
            <div class="card">
                <div class="card-header">Daftar User</div>

                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                            <tr>
                                <td>
                                    @if($item->foto)
                                    <img src="{{ asset('storage/foto/' . $item->foto) }}" alt="Foto Pengguna" style="max-width: 100px;">
                                    @else
                                        Tidak Ada Foto
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <a href="{{ route('edit.user', ['id' => $item->id]) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('delete.user', ['id' => $item->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" class="init">
    $(document).ready(function () {
        var table = $('#example').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });
    });
</script>

@endsection
