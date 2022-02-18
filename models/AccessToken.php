<?php

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $table = 'access_tokens';

    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'key',
        'secret',
        'secret_salt',
        'whitelist_range',
        'active'
    ];

    protected $casts = [
        'whitelist_range' => 'array',
        'active' => 'boolean'
    ];
}
