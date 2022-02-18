<?php

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public $timestamps = true;

    const UPDATED_AT = null;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
    ];


}
