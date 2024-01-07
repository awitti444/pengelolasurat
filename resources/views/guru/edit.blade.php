@extends('layouts.app')
  
@section('title', 'Edit Data Guru')
  
@section('contents')
    <h1 class="mb-0">Edit Guru</h1>
    <hr />
    <form action="{{ route('guru.update', $guru['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" placeholder="name" value="{{ $guru->name }}" >
            </div>
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email" value="{{ $guru->email }}" >
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="password" id="password" name="password" >
            </div>
            {{-- <div class="col mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" placeholder="Descriptoin" >{{ $product->description }}</textarea>
            </div> --}}
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection