
    @extends('layouts.app')
    @section('title', 'Home / Data Surat')
    @section('contents')
    <div class="d-flex align-items-center justify-content-between mb-3">
        {{-- <h1 class="mb-0">Data Surat</h1> --}}
        <div class="d-flex">
            <a href=" {{ route('surat.create') }}" class="btn btn-primary me-2">Tambah</a>
            <a href="{{ route('surat.export') }}" class="btn btn-info">Export Klasifikasi Surat</a>
            <form method="GET" action="#">
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
        {{-- @foreach($letters as $letter)
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">{{ $letter->letter_perihal }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $letter->recipients }}</p>
                <!-- Tambahkan informasi lain yang ingin ditampilkan -->
            </div>
        </div>
    @endforeach --}}
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Perihal</th>
                    <th>Tanggal Keluar</th>
                    <th>Penerima Surat</th>
                    <th>Notulis</th>
                    <th>Hasil Rapat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php $no = 1 ?>
            @foreach($letter as $item)
            <tr>
                <td>{{$no++}}</td>
                    <td>{{$item->letterType->letter_code}}/000{{$item->id}}/SMK Wikrama/XII/{{ date('Y') }}</td>
                    <td>{{$item->letter_perihal}}</td>
                    <td>{{$item->created_at->format('j F Y')}}</td>
                    <td>{{implode(', ', array_column($item->recipients, 'name'))}}</td>
                    <td>{{ $item->guru ? $item->guru->name : 'N/A' }}</td>
                    <td>
                        @if (App\Models\Result::where('letter_id', $item->id)->exists())
                            <p class="text-success">Sudah dibuat</p>
                        @else
                            <p class="text-danger">Belum Dibuat</p>
                        @endif
                    </td>
                    {{-- <td>
                        <a href="{{route('surat.detail', $item['id'])}}">Lihat</a><br>
                        <a href="{{route('surat.edit', $item['id'])}}" class="btn btn-warning">Edit</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $item['id']}}">Hapus</button>
                    </td>
                </tr>
                <div class="modal fade" id="confirmDeleteModal-{{ $item['id']}}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="confirmDeleteModalLabel">Konfirmasi hapus</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Yakin ingin menghapus data ini?
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('data.datasurat.delete', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- </tbody>
        @endforeach
    </table>
@endsection --}}
                <td>
                    <a href="{{route('surat.detail', $item['id'])}}">Lihat</a><br>
                    <a class="btn btn-primary me-2" href="{{route('surat.edit', $item['id'])}}">Edit</a>
                    <form method="POST" action="{{ route('surat.destroy', $item['id'])}}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus Data?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    @endsection
