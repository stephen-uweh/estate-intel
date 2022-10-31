<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isbn',
        'authors',
        'country',
        'number_of_pages',
        'publisher',
        'release_date'
    ];

    // protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'authors' => 'array'
    ];
}
