<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordSubCategory extends Model
{
    use HasFactory;

    protected $table = 'record_sub_category';

    protected $fillable = ['category_id', 'quantity', 'price'];
}
