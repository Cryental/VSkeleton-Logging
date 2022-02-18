<?php

use Carbon\Carbon;

const LOGGING_START = true;

require __DIR__.'/../init.php';

Flight::map('notFound', function () {
    Flight::json(MessagesCenter::E404("No Route Found"), 404);
});

Flight::route('POST /logs/admins', function () {
    try {
        $token = AuthHelper::Auth();

        if (!$token) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }

        if(!RequestValidator::ValidateAdminLogRequest()) {
            Flight::json(MessagesCenter::E400(), 400);
            return;
        }


        $adminLogRepo = new AdminLogRepository();
        $log = $adminLogRepo->Create([
            'logging_access_token_id' => $token->id,
            'access_token_id'         => Flight::request()->data->access_token_id,
            'url'                     => Flight::request()->data->url,
            'ip'                      => Flight::request()->data->ip,
            'method'                  => Flight::request()->data->method,
            'user_agent'              => Flight::request()->data->user_agent,
        ]);

        Flight::json($log, 201);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('GET /logs/admins/', function () {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }

        $needle = Flight::request()->query['search'] ?? '';
        $page = Flight::request()->query['page'] ?? 1;
        $limit = Flight::request()->query['limit'] ?? 50;

        $adminLogRepo = new AdminLogRepository();
        $logs = $adminLogRepo->FindAll(
            $needle,
            $page,
            $limit
        );
        Flight::json($logs);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('POST /logs/users', function () {
    try {
        $token = AuthHelper::Auth();

        if (!$token) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }
        if(!RequestValidator::ValidateUserLogRequest()) {
            Flight::json(MessagesCenter::E400(), 400);
            return;
        }

        $userLogRepo = new UserLogRepository();
        $log = $userLogRepo->Create([
            'logging_access_token_id' => $token->id,
            'subscription_id'         => Flight::request()->data->subscription_id,
            'url'                     => Flight::request()->data->url,
            'ip'                      => Flight::request()->data->ip,
            'method'                  => Flight::request()->data->method,
            'user_agent'              => Flight::request()->data->user_agent,
        ]);

        Flight::json($log);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('GET /logs/users/@subscription_id/count', function ($subscription_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }

        $date = Flight::request()->query['date'] ?? Carbon::now();

        $userLogRepo = new UserLogRepository();
        $count = $userLogRepo->FindSubscriptionLogsCount($subscription_id, $date);
        http_response_code(200);
        Flight::json($count);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('GET /logs/users/@subscription_id', function ($subscription_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }
        $needle = Flight::request()->query['search'] ?? '';
        $page = Flight::request()->query['page'] ?? 1;
        $limit = Flight::request()->query['limit'] ?? 50;

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindSubscriptionLogs(
            $subscription_id,
            $needle,
            $page,
            $limit
        );
        Flight::json($logs);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('GET /logs/users/', function () {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }

        $needle = Flight::request()->query['search'] ?? '';
        $page = Flight::request()->query['page'] ?? 1;
        $limit = Flight::request()->query['limit'] ?? 50;

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindAll(
            $needle,
            $page,
            $limit
        );

        Flight::json($logs);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('GET /logs/users/@subscription_id/usages', function ($subscription_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);
            return;
        }

        $date = Flight::request()->query['date'] ?? Carbon::now();

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindSubscriptionUsages($subscription_id, $date);
        http_response_code(200);
        Flight::json($logs);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::start();
