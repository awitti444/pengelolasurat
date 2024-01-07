<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;
    protected $table = 'letters';
    protected $primaryKey = 'id';

    protected $fillable = [
        'letter_type_id',
        'letter_perihal',
        'recipients',
        'content',
        'attachment',
        'notulis_id',
    ];

    protected $casts = [
        'recipients' => 'array'
    ];


    public function guru()
    {
        return $this->belongsTo(Guru::class, 'notulis_id', 'id');
    }

    //ke lettertype ngambil kode surat letter_code
    public function letterType(){
        return $this->belongsTo(LetterType::class,'letter_type_id', 'id');
    }

    public function result() {
        return $this->hasMany(Result::class, 'letter_id', 'id');

}
}