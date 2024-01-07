@extends('layouts.app')

@section('title', 'Home / Data Guru')
@section('contents')
<div class="d-flex align-items-center justify-content-between mb-3">
    {{-- <h1 class="mb-0">Data Guru</h1> --}}
    <div class="d-flex">
        <a href="{{ route('guru.create') }}" class="btn btn-primary me-2">Tambah</a>
        <form method="GET" action="{{ route('guru.index') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama...">
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
            </div>
        </form>
    </div>
</div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $no = 1 ?>
        @foreach($rows as $row)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->role }}</td>
            <td>
                <a class="btn btn-primary me-2" href="{{ route('guru.edit', $row['id']) }}">Edit</a>
                <form method="POST" action="{{ route('guru.destroy', $row['id']) }}" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Hapus Data?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection