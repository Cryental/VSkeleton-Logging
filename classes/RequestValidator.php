<?php

use Carbon\Carbon;

class RequestValidator
{
    public static function ValidateUserLogRequest(): bool
    {
        $subscription_id = Flight::request()->data->subscription_id;
        if (!is_string($subscription_id) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $subscription_id)) !== 1) {
            return false;
        }

        $url = Flight::request()->data->url;
        if ($url == null ||
            (!filter_var($url, FILTER_VALIDATE_URL))) {
            return false;
        }

        $ip = Flight::request()->data->ip;
        if ($ip == null ||
            (!filter_var($ip, FILTER_VALIDATE_IP))) {
            return false;
        }

        $method = Flight::request()->data->method;
        if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            return false;
        }

        return  true;
    }

    public static function ValidateAdminLogRequest(): bool
    {
        $access_token_id = Flight::request()->data->access_token_id;
        if (!is_string($access_token_id) ||
            (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $access_token_id)) !== 1) {
            return false;
        }

        $url = Flight::request()->data->url;
        if ($url == null ||
            (!filter_var($url, FILTER_VALIDATE_URL))) {
            return false;
        }

        $ip = Flight::request()->data->ip;
        if ($ip == null ||
            (!filter_var($ip, FILTER_VALIDATE_IP))) {
            return false;
        }

        $method = Flight::request()->data->method;
        if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            return false;
        }

        return  true;
    }

    public static function ValidatePaginatedRequest($page, $limit): bool
    {
        return ctype_digit($page) && ctype_digit($limit);
    }

    public static function ValidateDate($date){
        try {
            Carbon::parse($date);
            return true;
        } catch (Exception) {
            return false;
        }
    }

    public static function ValidateUsageRequest($date, $mode): bool
    {
        return self::ValidateDate($date) && (in_array($mode,['detailed','focused'])) ;
    }
}
