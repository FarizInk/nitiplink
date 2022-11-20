<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Tag extends Model
{
    use HasFactory, HashableId;

    protected $hidden = ['id'];
    protected $appends = ['hash'];
    protected $guarded = [];
}
