<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use App\Models\Letter;
use App\Models\Guru;
use App\Models\LetterType;
use App\Models\User;
use App\Models\Result;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LetterExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDF;


class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
        // $letters = Letter::with('LetterType', 'guru')->get();
        // return view('surat.index', compact('letters'));

        public function export() {
            return Excel::download(new LetterExport, 'Data Surat.xlsx');
        }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $query = Letter::with('user');
        // $letter = $query->simplePaginate(10);
        $letter = Letter::with('letterType', 'guru')->get();
        return view('surat.index', compact('letter'));
    }

    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::all()->where('role', 'guru');
        $kualifikasiSuratOptions = LetterType::all();

        return view('surat.create', compact('kualifikasiSuratOptions', 'guru'));
        // $guru = Guru::all()->where('role', 'guru');
        // $data = LetterType::all();

        // return view('surat.create', compact('data','guru'));

        // return view('surat.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {
        $request->validate([
            'letter_type_id' => 'required',
            'letter_perihal' => 'required',
            'recipients' => 'required|array',
            'content' => 'required',
            'attachment' => 'sometimes|nullable',
            'notulis_id' => 'required',
        ], [
            'letter_type_id.required' => 'Klasifikasi Surat wajib diisi.',
            'letter_perihal.required' => 'Perihal wajib diisi.',
            'recipients.required' => 'Penerima Surat wajib diisi.',
            'recipients.array' => 'Penerima Surat harus berupa array.',
            'content.required' => 'Isi Surat wajib diisi.',
            'attachment.sometimes' => 'Lampiran wajib diisi.',
            'notulis_id.required' => 'Notulis wajib diisi.',
        ]);
        
        // Pastikan $request->recipients bukan null sebelum menggunakannya
        if ($request->recipients !== null) {
            $arrayDistinct = array_count_values($request->recipients);
            $arrayAssoc = [];
        
            foreach ($arrayDistinct as $id => $count) {
                $guru = Guru::find($id);
        
                // Periksa apakah pengguna ditemukan sebelum mengakses properti 'name'
                if ($guru) {
                    $arrayItem = [
                        "id" => $id,
                        "name" => $guru->name,
                    ];
        
                    array_push($arrayAssoc, $arrayItem);
                }
            }
        
            $request['recipients'] = $arrayAssoc;
        
            // Hitung jumlah surat sebelum menyimpan
            $totalLettersBefore = Letter::count();
        
            // Menyimpan data surat
            $process = Letter::create([
                'letter_type_id' => $request->letter_type_id,
                'letter_perihal' => $request->letter_perihal,
                'recipients' => $request->recipients,
                'content' => $request->content,
                'attachment' => $request->attachment,
                'notulis_id' => $request->notulis_id,
            ]);
        
            // Hitung jumlah surat setelah menyimpan
            $totalLettersAfter = Letter::count();
        
            // Pengecekan berhasil atau gagalnya penyimpanan
            if ($process) {
                // Pesan flash success
                return redirect()->route('surat.index')->with('success', 'Data Klasifikasi Surat berhasil ditambahkan.');
            } else {
                // Log kesalahan atau pesan flash failed
                Log::error('Gagal menyimpan data surat');
                return redirect()->route('surat.index')->with('failed', 'Gagal membuat data surat.');
            }
        } else {
            // Atau tangani sesuai kebutuhan aplikasi Anda
            return redirect()->route('surat.index')->with('failed', 'Penerima Surat tidak valid.');
        }
    }
    // dd($request->all(), $arrayAssoc);

    // $process = Letter::create([
    //     'letter_perihal' => $request->letter_perihal,
    //     'letter_type_id' => $request->letter_type_id ,
    //     // . '/000' . $id . '/SMK Wikrama/XII/' . date('Y')
    //     'content' => $request->content,
    //     'recipients' => $request->recipients,
    //     'attachment' => $request->attachment,
    //     'notulis' => $request->notulis
    // ]);
    
    // if ($process) {
    //     // Assuming you want to find the latest created letter
    //     $letter = Letter::where('letter_type_id', $request->letter_type_id)
    //                     ->orderBy('created_at', 'DESC')
    //                     ->first();

    //                 } else {
    //                     // Log kesalahan atau tampilkan pesan kesalahan
    //                     Log::error('Gagal menyimpan data surat');
    //                     return redirect()->route('surat.index')->with('success', 'Gagal membuat data surat');
    //                 }
    
    //     if ($letter) {
    //         return redirect()->route('surat.index', $letter->id);
    //     } else {
    //         return redirect()->route('surat.index')->with('failed', 'Gagal menemukan data surat');
    //     }
    // } else {
    //     return redirect()->route('surat.index')->with('failed', 'Gagal membuat data surat');
    // }
        // $request->validate([
        //     'letter_perihal' => 'required',
        //     'letter_type_id' => 'required',
        //     'recipients' => 'required|array',
        //     'recipients.*' => 'exists:gurus,id',
        //     'content' => 'required|string',
        //     'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'notulis_id' => 'required',
        // ]);

        // $attachmentPath = $request->file('attachment')->storeAs('attachments', $request->file('attachment')->getClientOriginalName(), 'public');

        // $letter = Letter::create([
        //     'letter_perihal' => $request->letter_perihal,
        //     'letter_type_id' => $request->letter_type_id,
        //     'attachment' => $attachmentPath,
        //     'notulis_id' => $request->notulis_id,
        // ]);

        // // Attach recipients (gurus)
        // $letter->gurus()->attach($request->recipients);

        // // Attach content (if it is intended to be attached to the letter model)
        // $letter->content = $request->content;
        // $letter->save();

        // return redirect()->route('surat.index')->with('success', 'Berhasil menambahkan data surat!');


//     $arrayDistinct = array_count_values($request->recipients);
// $arrayAssoc = [];

// foreach ($arrayDistinct as $id => $count) {
//     $guru = Guru::find($id);

//     if ($guru) {
//         $arrayItem = [
//             "id" => $id,
//             "name" => $guru->name, // Mengasumsikan 'name' adalah properti dari model Guru
//         ];

//         array_push($arrayAssoc, $arrayItem);
//     }
// }

// $request['recipients'] = $arrayAssoc;

// $letter = Letter::create([
//     'letter_perihal' => $request->letter_perihal,
//     'letter_type_id' => $request->letter_type_id,
//     'content' => $request->content,
//     'recipients' => $arrayAssoc,
//     'attachment' => $request->attachment,
//     'notulis' => $request->notulis
// ]);

// return redirect()->route('surat.index')->with('success', 'Berhasil menambahkan data surat!');

    
     // if ($process) {
        // Assuming you want to find the latest created letter
        // $letter = Letter::where('letter_type_id', $request->letter_type_id)
        //                 ->orderBy('created_at', 'DESC')
        //                 ->first();
    
    //     if ($letter) {
    //         return redirect()->route('#', $letter->id);
    //     } else {
    //         return redirect()->route('surat.index')->with('failed', 'Gagal menemukan data surat');
    //     }
    // } else {
    //     return redirect()->route('surat.index')->with('failed', 'Gagal membuat data surat');
    // }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guru = Gueu::all()->where('role', 'guru');
        $letter = Letter::find($id);
        return view('surat.print', compact('letter', 'guru'));
    }

    public function detail($id)
    {
        $result = Result::where('letter_id', $id)->first();

        $guru = Guru::Where('role', 'guru')->get();

        $letter = Letter::find($id);
        return view('surat.detail', compact('letter', 'guru', 'result'));
    }

    public function downloadPDF($id) 
    { 
        $letter = Letter::find($id); 
        if (!$letter) {
            return response()->json(['error' => 'Surat tidak ditemukan'], 404);
        }
        view()->share('letter', $letter); 
        $pdf = PDF::loadView('surat.pdf', compact('letter')); 
        return $pdf->download('letter.pdf'); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $letter = Letter::findOrFail($id);

        // Menyiapkan data yang dibutuhkan, seperti daftar klasifikasi surat dan daftar guru
        $kualifikasiSuratOptions = LetterType::all(); // Sesuaikan dengan model dan field yang sesuai
        $guru = Guru::all(); // Sesuaikan dengan model dan field yang sesuai

        // Mengembalikan view edit dengan data yang diperlukan
        return view('surat.edit', compact('letter', 'kualifikasiSuratOptions', 'guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Letter $letter)
    {
        // Mendapatkan data penerima dari request atau menggunakan array kosong jika null
    $recipients = $request->recipients ?? [];
    
    // Menghitung nilai unik dan jumlah kemunculan
    $arrayDistinct = array_count_values($recipients);
    $arrayAssoc = [];

    foreach ($arrayDistinct as $id => $count) {
        $guru = Guru::find($id);

        // Periksa apakah pengguna ditemukan sebelum mengakses properti 'name'
        if ($guru) {
            $arrayItem = [
                "id" => $id,
                "name" => $guru->name,
            ];

            array_push($arrayAssoc, $arrayItem);
        }
    }

    // Menyimpan data penerima yang telah diproses ke dalam request
    $request['recipients'] = $arrayAssoc;

    // Validasi form dengan pesan kesalahan deskriptif
    $request->validate([
        'letter_type_id' => 'required',
        'letter_perihal' => 'required',
        'recipients' => 'required|array',
        'content' => 'required',
        // 'attachment' => 'required',
        'notulis_id' => 'required',
    ]);

    // Menyimpan data surat baru
    $process = $letter->update([
        'letter_type_id' => $request->letter_type_id,
        'letter_perihal' => $request->letter_perihal,
        'recipients' => $request->recipients,
        'content' => $request->content,
        'attachment' => $request->attachment,
        'notulis_id' => $request->notulis_id,
    ]);

    // Pengecekan berhasil atau gagalnya penyimpanan
    if ($process) {
        // Pesan flash success
        return redirect()->route('surat.index')->with('success', 'Data Berhasil Di Ubah.');
    } else {
        // Log kesalahan atau pesan flash failed
        Log::error('Gagal mengubah data surat');
        return redirect()->route('surat.index')->with('failed', 'Gagal mengubah data surat.');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Letter::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }
}
