<?php


class MessagesCenter
{
    public static function E400($error = 'One or more invalid fields were specified using the fields parameters.'): array
    {
        return self::Error('xInvalidParameters', $error);
    }
    
    public static function Error(string $type, $info): array
    {
        return [
            'error' => [
                'type' => $type,
                'info' => $info,
            ],
        ];
    }

    public static function E401($error = 'Insufficient permissions to perform this request.'): array
    {
        return self::Error('xUnauthorized', $error);
    }

    public static function E403($error = 'Forbidden request.'): array
    {
        return self::Error('xForbidden', $error);
    }

    public static function E404($error = 'No item found with provided parameters.'): array
    {
        return self::Error('xNotFound', $error);
    }

    public static function E409($error = 'could not be completed due to a conflict with the current state of the resource.'): array
    {
        return self::Error('xConflict', $error);
    }

    public static function E429($error = 'Too many requests.'): array
    {
        return self::Error('xManyRequests', $error);
    }

    public static function E500($error = 'Something went wrong with the server. Please try later.'): array
    {
        return self::Error('xUnknownError', $error);
    }
}
