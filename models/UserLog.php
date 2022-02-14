<?php

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';

    const UPDATED_AT = null;

    public $timestamps = true;

    protected $fillable = [
        'subscription_id',
        'url',
        'method',
        'ip',
        'user_agent',
    ];

    protected $casts = [
    ];
}
