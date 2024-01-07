 @extends('layouts.app')
@section('title', 'Home / Data Staff Tata Usaha')
@section('contents')
<div class="d-flex align-items-center justify-content-between mb-3">
    {{-- <h1 class="mb-0">Data Staff Tata Usaha</h1> --}}
    <div class="d-flex">
        <a href="{{ route('staffs.create') }}" class="btn btn-primary me-2">Tambah</a>
        <form method="GET" action="{{ route('staffs.index') }}">
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
                <a class="btn btn-primary me-2" href="{{ route('staffs.edit', $row['id']) }}">Edit</a>
                <form method="POST" action="{{ route('staffs.destroy', $row['id']) }}" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Hapus Data?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection

{{-- @extends('layouts.app')
@section('content')
@if(session('success'))
<p class="alert alert-success">{{ session('success') }}</p>
@endif
<div class="card card-default">
    <div class="card-header">
        <form class="form-inline">
            <div class="form-group mr-1">
                <input class="form-control" type="text" name="q" value="{{ $q}}" placeholder="Pencarian..." />
            </div>
            <div class="form-group mr-1">
                <button class="btn btn-success">Cari</button>
            </div>
            <div class="form-group mr-1">
                <a class="btn btn-primary" href="{{ route('staffs.create') }}">Tambah</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            ?php $no = 1 ?>
            @foreach($rows as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->role }}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="#">Ubah</a>
                    <form method="POST" action="{{ route('staffs.destroy', $row) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus Data?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection --}}


