<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_Amounts extends Model
{
    use HasFactory;

//    protected $fillable = ['main_amount'];
    protected $guarded = [];

    public function calculateAmount()
    {
        return $this->hasMany(Calculate_Amounts::class);
    }
}
