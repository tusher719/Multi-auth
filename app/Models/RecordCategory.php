<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordCategory extends Model
{
    use HasFactory;

    protected $table = 'record_category';

    protected $fillable = ['name'];


    public function stocks(): HasMany
    {
        return $this->hasMany(RecordSubCategory::class, 'category_id');
    }
    
}
