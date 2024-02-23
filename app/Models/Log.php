<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;


class Log extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = ['id'];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
