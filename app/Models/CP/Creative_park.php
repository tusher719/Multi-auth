<?php

namespace App\Models\CP;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative_park extends Model
{
    use HasFactory;
    //    protected $guarded = [];
    protected $fillable = [
        'auth_id',
        'student_id',
        'name',
        'email',
        'phone',
        'phone_2',
        'batch',
        'section',
        'gender',
        'date',
        'blood',
        'status',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->as('tags');
    }

    public function panel()
    {
        return $this->belongsTo(Panel::class, 'panel_id', 'id');
    }
}
