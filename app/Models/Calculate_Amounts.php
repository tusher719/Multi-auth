<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculate_Amounts extends Model
{
    use HasFactory;
//    protected $fillable = ['main_amount_id', 'name', 'amount', 'due', 'extra'];

    protected $guarded = [];
    public function mainAmount()
    {
        return $this->belongsTo(Main_Amounts::class);
    }
}
