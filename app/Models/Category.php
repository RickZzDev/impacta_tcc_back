<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'maxValue'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function debits()
    {
        return $this->hasMany(Debit::class);
    }

    public static function getDefaultCategories($monthlyIncome)
    {
        if (empty($monthlyIncome)) {
            return [
                [
                    'title' => "Entretenimento",
                    'maxValue' => 0
                ],
                [
                    'title' => "Entretenimento",
                    'maxValue' => 0
                ],
                [
                    'title' => "Entretenimento",
                    'maxValue' => 0
                ]
            ];
        }

        return [
            [
                'title' => "Gastos essenciais",
                'maxValue' => $monthlyIncome * 0.6
            ],
            [
                'title' => "Entretenimento",
                'maxValue' => $monthlyIncome * 0.1
            ],
            [
                'title' => "Viagens",
                'maxValue' => $monthlyIncome * 0.3
            ]
        ];
    }
}
