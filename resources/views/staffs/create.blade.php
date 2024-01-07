@extends('layouts.app')
  
@section('title', 'Tambah')
  
@section('contents')
    <h1 class="mb-0">Data Staff Tata Usaha</h1>
    <hr />
    <form action="{{ route('staffs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        
        <div class="row mb-3">
            <div class="col">
                <label for="name">Nama <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama">
            </div>
            <div class="col">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email">
            </div>
        </div>
{{--     
        <div class="row mb-3">
            <div class="col">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
            </div> --}}
            <div class="col">
                <label for="role">Role <span class="text-danger">*</span></label>
                <select id="role" name="role" class="form-control">
                    <option value="staff">Staff</option>
                    <option value="guru">Guru</option>
                </select>
            </div>
            <br>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    </form>
@endsection