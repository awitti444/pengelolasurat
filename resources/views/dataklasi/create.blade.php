@extends('layouts.app')
  
@section('title', 'Tambah')
  
@section('contents')
    <h1 class="mb-0">Data Klasifikasi Surat</h1>
    <hr />
    <form action=" {{ route('dataklasi.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="letter_code">Kode Surat <span class="text-danger">*</span></label>
                <input type="text" id="letter_code" name="letter_code" class="form-control" placeholder="Kode Surat">
            </div>
            <div class="col">
                <label for="name_type">Klasifikasi Surat<span class="text-danger">*</span></label>
                <select id="name_type" name="name_type" class="form-control">
                    <option value="rapat guru">Rapat Guru</option>
                    <option value="rapat rutin">Rapat Rutin</option>
                </select>
                {{-- <input type="text" id="name_type" name="name_type" class="form-control" placeholder="Klasifikasi Surat"> --}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection