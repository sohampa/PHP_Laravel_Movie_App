<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre',
        'release_year',
    ];

    protected $casts = [
        'release_year' => 'integer',
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'release_year' => 'nullable|integer|min:1900|max:2030',
        ];
    }
}
