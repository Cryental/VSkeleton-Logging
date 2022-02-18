<?php

class RequestValidator
{
    public static  function ValidateUserLogRequest(){
        $subscription_id  = Flight::request()->data->subscription_id;
        if (!is_string($subscription_id) ||
            (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $subscription_id) ) !== 1) {
            return false;
        }

        $url = Flight::request()->data->url;
        if($url == null ||
            (!filter_var($url, FILTER_VALIDATE_URL))) {
            return false;
        }

        $ip = Flight::request()->data->ip;
        if($ip == null ||
            (!filter_var($ip, FILTER_VALIDATE_IP))) {
            return false;
        }

        $method = Flight::request()->data->method ;
        if(!in_array($method, ['GET','POST','PUT','PATCH','DELETE'])){
            return false;
        }
        return  true;
    }

    public static  function ValidateAdminLogRequest(){
        $access_token_id  = Flight::request()->data->access_token_id;
        if (!is_string($access_token_id) ||
            (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $access_token_id) ) !== 1) {
            return false;
        }

        $url = Flight::request()->data->url;
        if($url == null ||
            (!filter_var($url, FILTER_VALIDATE_URL))) {
            return false;
        }

        $ip = Flight::request()->data->ip;
        if($ip == null ||
            (!filter_var($ip, FILTER_VALIDATE_IP))) {
            return false;
        }

        $method = Flight::request()->data->method ;
        if(!in_array($method, ['GET','POST','PUT','PATCH','DELETE'])){
            return false;
        }

        return  true;
    }

}