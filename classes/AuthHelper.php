<?php

use Wikimedia\IPSet;

class AuthHelper
{
    public static function GetAuthHeaders()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER['Authorization']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        return $headers;
    }

    public static function GetBearerToken()
    {
        $headers = self::GetAuthHeaders();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public static function Auth()
    {
        $tokenRepo = new AccessTokenRepository();

        $token = $tokenRepo->GetAccessToken(AuthHelper::GetBearerToken());

        if (!$token) {
            return null;
        }

        if (!$token->active) {
            return false;
        }

        $ipSet = new IPSet($token->whitelist_range);
        if (!empty($token->whitelist_range) && !$ipSet->match(Flight::request()->ip)) {
            return false;
        }

        return $token;
    }
}
