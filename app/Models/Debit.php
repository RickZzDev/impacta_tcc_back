<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'value'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
