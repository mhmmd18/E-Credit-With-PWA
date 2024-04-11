<?php

namespace App\Models;

use App\Models\Buyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Smoke extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function buyers()
    {
        return $this->hasMany(Buyer::class);
    }
}
