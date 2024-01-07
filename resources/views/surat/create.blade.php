@extends('layouts.app')
@section('title', 'Tambah')
@section('contents')
    <h1 class="mb-0">Data Surat</h1>
    <hr />
    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('failed'))
        <div class="alert alert-failed">{{ Session::get('failed') }}</div>
    @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="row mb-3">
            <div class="col mb-3">
                <label for="letter_perihal">Perihal <span class="text-danger">*</span></label>
                <input type="text" id="letter_perihal" name="letter_perihal" class="form-control" placeholder="Perihal">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col mb-3">
                <label for="letter_type_id">Klasifikasi Surat <span class="text-danger">*</span></label>
                <select id="letter_type_id" name="letter_type_id" class="form-control">
                    @foreach($kualifikasiSuratOptions as $letterTypes)
                        <option value="{{ $letterTypes->id }}">{{ $letterTypes->name_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col mb-3">
                <label for="content">Isi Surat<span class="text-danger">*</span></label>
                <textarea class="form-control" id="des" name="content"></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col mb-3">
                <label for="recipients">Nama<span class="text-danger">*</span></label>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Peserta (ceklis jika "ya")</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guru as $gurus)
                            <tr>
                                <td>{{ $gurus->name }}</td>
                                <td>
                                    <div class="form-check">
                                        <!-- Perhatikan perubahan pada name -->
                                        <input type="checkbox" class="form-check-input" name="recipients[]" id="guru_{{ $gurus->id }}" value="{{ $gurus->id }}">
                                        <label class="form-check-label" for="guru_{{ $gurus->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>        
        <div class="row mb-3">
            <div class="col mb-3">
                <label for="attachment">Lampiran<span class="text-danger">*</span></label>
                <input type="file" name="attachment" class="form-control" placeholder="Lampiran" accept="image/*">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col mb-3">
                <label for="notulis_id">Notulis<span class="text-danger">*</span></label>
                <select id="notulis_id" name="notulis_id" class="form-control" required>
                @foreach($guru as $gurus)
                    <option value="{{ $gurus->id }}">{{ $gurus->name }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <script>
            ClassicEditor
            .create(document.querySelector('#des'))
            .catch(error => {
                console.error(error)
            });
        </script>
    </form>
@endsection
