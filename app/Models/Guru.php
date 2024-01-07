<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'name',
        'email',
        'password',
        'role',
    ];

    public function letter()
    {
        return $this->hasMany(Letter::class, 'notulis_id', 'id');
    }

    
}
