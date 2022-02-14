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
        'permissions',
        'whitelist_range',
    ];

    protected $casts = [
        'permissions'     => 'array',
        'whitelist_range' => 'array',
    ];
}
