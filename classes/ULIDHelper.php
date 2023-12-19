<?php

use Ulid\Ulid;

class ULIDHelper
{
    public static function GetULID(): string
    {
        $ulid = (string)Ulid::generate(true);

        return substr($ulid, 0, 8) . '-' .
            substr($ulid, 8, 4) . '-' .
            substr($ulid, 12, 4) . '-' .
            substr($ulid, 16, 4) . '-' .
            substr($ulid, 20);
    }
}
