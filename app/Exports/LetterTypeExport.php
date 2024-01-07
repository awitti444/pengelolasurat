<?php

namespace App\Exports;

use App\Models\LetterType;
use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class LetterTypeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LetterType::all();
    }

    public function headings(): array
    {
        return [
            "Kode Surat", "Klasifikasi Surat", "Surat Tertaut"
        ];
    }

    public function map($LetterType): array
    {
        return [
            $LetterType->letter_code,
            $LetterType->name_type,
            Letter::where('letter_type_id', $LetterType->id)->count()
        ];
    }

    public function title(): string
    {
        return 'Klasifikasi Surat';
    }
}
