<?php

namespace App\Models;

use App\Models\CP\Creative_park;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user(){
        return $this->belongsTo(User::class,'auth_id','id');
    }

    public function students() {
        return $this->belongsToMany(Creative_park::class);
    }
}
