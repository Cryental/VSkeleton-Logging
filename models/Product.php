<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    public $timestamps = true;

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
    ];

    public function accessTokens(): HasMany
    {
        return $this->hasMany(AccessToken::class);
    }
}
