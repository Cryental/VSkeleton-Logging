<?php

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use UuidForKey;

    protected $table = 'user_logs';

    const UPDATED_AT = null;

    public $timestamps = true;

    protected $fillable = [
        'personal_token_id',
        'url',
        'method',
        'ip',
        'user_agent',
    ];

    protected $casts = [
    ];
}