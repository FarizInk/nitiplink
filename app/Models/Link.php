<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Link extends Model
{
    use HasFactory, SoftDeletes, HashableId;

    protected $hidden = ['id'];
    protected $appends = ['hash'];

    public function creator(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updateBy(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function community(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Community::class, 'id', 'community_id');
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_link', 'link_id', 'tag_id');
    }
}
