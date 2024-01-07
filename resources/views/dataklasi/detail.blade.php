@extends('layouts.app')
  
@section('title', 'Detail')
  
@section('contents')
<h1 class="mb-0"><a href="{{ route('dataklasi.index') }}">Klasifikasi Surat</a></h1>
<hr />
    <div class="jumbotron py-4 px-5">
        <h2>{{ $letterTypes['letter_code'] }} <p class="lead" style="display: inline;"> | {{ $letterTypes['name_type'] }}</p></h2>
        <br>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between">{{ $letterTypes['name_type'] }}
                        <a href="{{ route('dataklasi.download', $letterTypes['id'])}}">Download</a>
                    </h5>
                    @php
                    $no = 1;
                    @endphp 
                    <div class="card-body">
                        <p class="card-text">{{ $letterTypes->created_at->format('j F Y') }}</p>
                        @foreach($guru as $gurus)
                        <p class="card-text">{{$no++}}. {{ $gurus->name }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
{{-- @section('content')
    <div class="jumbotron py-4 px-5">
        <h2>{{ $letterTypes['letter_code'] }} <p class="lead" style="display: inline;"> | {{ $letterTypes['name_type'] }}</p></h2>
        <br>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between">{{ $letterTypes['name_type'] }}
                        <a href="#"><i class="bi bi-download"></i></a>
                    </h5>
                    @php
                    $no = 1;
                    @endphp 
                    <div class="card-body">
                        <p class="card-text">{{ $letterTypes->created_at->format('j F Y') }}</p>
                        @foreach($guru as $gurus)
                        <p class="card-text">{{$no++}}. {{ $gurus->name }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}