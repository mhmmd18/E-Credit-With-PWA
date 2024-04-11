<?php

namespace App\Models;

use App\Models\Smoke;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Buyer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $attributes = [
        'status' => 'Belum Lunas',
    ];
    public function smoke()
    {
        return $this->belongsTo(Smoke::class);
    }
}
