<?php

namespace App\Http\Controllers;

use App\Models\LetterType;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Exports\LetterTypeExport;
use PDF;

class KlasiController extends Controller
{

    public function export() {
        return Excel::download(new LetterTypeExport, 'Klasifikasi Surat.xlsx');
    }

    // public function lettertypeexport(){
    //     return Excel::download(new LetterTypeExport, 'Klasifikasi.xlsx');
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = LetterType::query();

        if (!empty($search)) {
            $query->where('letter_code', 'like', '%' . $search . '%');
        }

        $letterTypes = $query->get();

        return view('dataklasi.index', compact('letterTypes'));
        // $letterTypes = LetterType::all();
        // return view('dataklasi.index', compact('letterTypes'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('dataklasi.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required|unique:letter_types',
            'name_type' => 'required',
        ]);

        $LetterTypes = LetterType::count();

        LetterType::create([
            'letter_code' => $request->letter_code . '-' . $LetterTypes,
            'name_type' => $request->name_type
        ]);

        $letterTypes = LetterType::count();
        
        return redirect()->route('dataklasi.index')->with('success', 'Data Klasifikasi Surat berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        
        $guru = Guru::all()->where('role', 'guru');
        $letterTypes = LetterType::find($id);
        return view('dataklasi.detail', compact('letterTypes', 'guru'));
    }

    public function downloadPDF($id) 
    { 
        // Ambil objek model Letters berdasarkan ID
        $letterTypes = LetterType::find($id); 
    
        // Periksa apakah surat ditemukan
        if (!$letterTypes) {
            // Lakukan penanganan jika surat tidak ditemukan
            // Misalnya, redirect ke halaman tertentu atau tampilkan pesan kesalahan
            // Di sini, saya mengembalikan response dengan pesan kesalahan
            return response()->json(['error' => 'Surat tidak ditemukan'], 404);
        }
    
        // Kirim objek model surat ke view
        view()->share('letterTypes', $letterTypes); 
    
        // Panggil view blade yang akan dicetak PDF serta data yang akan digunakan
        $pdf = PDF::loadView('dataklasi.pdf', compact('letterTypes')); 
    
        // Download PDF file dengan nama tertentu
        return $pdf->download('data klasifikasi.pdf'); 
    }

    public function edit($id)
    {
        $letterTypes = LetterType::find($id); // first itu array assosiatif
        return view('dataklasi.edit', compact('letterTypes')); 
    }

    public function update(Request $request, $id )
    {
        $request->validate([
            'letter_code' => 'required|min:3',
            'name_type' => 'required',
        ]);

        $LetterTypes = LetterType::count();

        $Data = [
            'letter_code' => $request->letter_code . '-' . $LetterTypes,
            'name_type' => $request->name_type
        ];

        $LetterTypes = LetterType::count();

        LetterType::where('id', $id)->update($Data);

        return redirect()->route('dataklasi.index')->with('success', 'Berhasil mengubah data!');
    }

    public function destroy($id)
    {
        LetterType::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }

}