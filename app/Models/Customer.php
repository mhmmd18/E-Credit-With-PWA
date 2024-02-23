<?php

namespace App\Models;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;





class Customer extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = ['id'];
    
    protected $attributes = [
        'status' => 'Belum Lunas',
    ];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}

