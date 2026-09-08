<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $table = 'categories'; // Nama tabel di database
    protected $fillable = [
        'categoryName',
        'categoryDescription'
    ];
}

