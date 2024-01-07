<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;
    protected $table = 'letter_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'letter_code',
        'name_type',
    ];

    public function guru()
    {
        return $this->hasMany(Guru::class);
    }

    public function letter() {
        return $this->hasMany(Letter::class, 'letter_type_id', 'id');
    }
}
