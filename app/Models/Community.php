<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Community extends Model
{
    use HasFactory, SoftDeletes, HashableId;

    protected $guarded = [];
    protected $appends = ['hash'];
    protected $hidden = ['id'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_user', 'community_id', 'user_id')->withPivot(['role']);
    }

    public function webhooks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Webhook::class);
    }
}
