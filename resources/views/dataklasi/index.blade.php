@extends('layouts.app')
@section('title', 'Home / Data Klasifikasi Surat')
@section('contents')
<script src= "https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<div class="d-flex align-items-center justify-content-between mb-3">
    {{-- <h1 class="mb-0">Data Klasifikasi Surat</h1> --}}
    <div class="d-flex">
        <a href=" {{ route('dataklasi.create') }}" class="btn btn-primary">Tambah</a>
        <a href="{{ route ('dataklasi.export')}} " class="btn btn-info">Export Klasifikasi Surat</a>
        <form method="GET" action="{{ route('dataklasi.index') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari...">
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
                <th>Kode Surat</th>
                <th>Klasifikasi Surat</th>
                <th>Surat Tertaut</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $no = 1; ?>
            @foreach ($letterTypes as $LetterType)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $LetterType->letter_code}}</td>
                    <td>{{ $LetterType->name_type }}</td>
                    {{-- <td>{{ $LetterType->surat_tertaut }}</td> --}}
                    <td>{{ App\Models\Letter::where('letter_type_id', $LetterType->id)->count() }}</td>
                    <td>
                        <a href="{{ route('dataklasi.show', $LetterType['id']) }}">Lihat</a>
                        <a class="btn btn-primary me-2" href="{{ route('dataklasi.edit', $LetterType->id) }}">Edit</a>
                        <form method="POST" action="{{ route('dataklasi.destroy', $LetterType->id) }}" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Hapus Data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
    </table>
@endsection