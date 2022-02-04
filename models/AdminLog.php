<?php

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use UuidForKey;

    protected $table = 'admin_logs';

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