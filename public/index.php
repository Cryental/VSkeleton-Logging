<?php

use Carbon\Carbon;

const LOGGING_START = true;

require __DIR__ . '/../init.php';

Flight::map('notFound', function () {
    Flight::json(MessagesCenter::E404('No Route Found'), 404);
});

Flight::route('POST /admins/logs', function () {
    try {
        $token = AuthHelper::Auth();

        if (!$token) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }

        if (!RequestValidator::ValidateAdminLogRequest()) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }

        $adminLogRepo = new AdminLogRepository();
        $log = $adminLogRepo->Create([
            'logging_access_token_id' => $token->id,
            'access_token_id' => Flight::request()->data->access_token_id,
            'url' => Flight::request()->data->url,
            'ip' => Flight::request()->data->ip,
            'method' => Flight::request()->data->method,
            'user_agent' => Flight::request()->data->user_agent,
        ]);

        Flight::json(AdminLogDTO::fromModel($log)->GetDTO(), 201);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});
Flight::route('GET  /admins/logs', function () {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }

        $search = Flight::request()->query['search'] ?? '';
        $page = Flight::request()->query['page'] ?? '1';
        $limit = Flight::request()->query['limit'] ?? '50';

        if (!RequestValidator::ValidatePaginatedRequest($page, $limit)) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }

        $adminLogRepo = new AdminLogRepository();
        $logs = $adminLogRepo->FindAll(
            $search,
            $page,
            $limit
        );
        if (!$logs) {
            Flight::json(MessagesCenter::E400('Invalid search column'), 400);
        }

        $logDTOs = [];
        foreach ($logs->items() as $log) {
            $logDTOs[] = AdminLogDTO::fromModel($log)->GetDTO();
        }

        Flight::json([
            'pagination' => [
                'per_page' => $logs->perPage(),
                'current' => $logs->currentPage(),
                'total' => $logs->currentPage(),
            ],
            'items' => $logDTOs,
        ]);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});
Flight::route('GET  /admins/logs/@log_id', function ($log_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }

        $adminLogRepo = new AdminLogRepository();
        $log = $adminLogRepo->Find($log_id);

        if ($log) {
            Flight::json(MessagesCenter::E404(), 400);
        }

        Flight::json(AdminLogDTO::fromModel($log)->GetDTO(), 200);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('POST /users/logs', function () {
    try {
        $token = AuthHelper::Auth();

        if (!$token) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }
        if (!RequestValidator::ValidateUserLogRequest()) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }
        $userLogRepo = new UserLogRepository();
        $log = $userLogRepo->Create([
            'logging_access_token_id' => $token->id,
            'subscription_id' => Flight::request()->data->subscription_id,
            'user_id' => Flight::request()->data->user_id,
            'url' => Flight::request()->data->url,
            'ip' => Flight::request()->data->ip,
            'method' => Flight::request()->data->method,
            'user_agent' => Flight::request()->data->user_agent,
        ]);
ray($log);
        Flight::json(UserLogDTO::fromModel($log)->GetDTO(), 201);
    } catch (Exception $ex) {
        ray($ex);
        Flight::json(MessagesCenter::E500(), 500);
    }
});
Flight::route('GET /users/logs', function () {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }

        $needle = Flight::request()->query['search'] ?? '';
        $page = Flight::request()->query['page'] ?? '1';
        $limit = Flight::request()->query['limit'] ?? '50';

        if (!RequestValidator::ValidatePaginatedRequest($page, $limit)) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindAll(
            $needle,
            $page,
            $limit
        );

        if (!$logs) {
            Flight::json(MessagesCenter::E400('Invalid search column'), 400);
        }

        $logDTOs = [];
        foreach ($logs->items() as $log) {
            $logDTOs[] = UserLogDTO::fromModel($log)->GetDTO();
        }

        Flight::json([
            'pagination' => [
                'per_page' => $logs->perPage(),
                'current' => $logs->currentPage(),
                'total' => $logs->lastPage(),
            ],
            'items' => $logDTOs,
        ]);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});
Flight::route('GET  /users/logs/@log_id', function ($log_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }

        $repository = new UserLogRepository();
        $log = $repository->Find($log_id);

        if ($log) {
            Flight::json(MessagesCenter::E404(), 400);
        }

        Flight::json(UserLogDTO::fromModel($log)->GetDTO(), 200);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::route('GET /users/@user_id/subscriptions/@subscription_id/count', function ($user_id, $subscription_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }
        $date = Flight::request()->query['date'] ?? Carbon::now();

        if (!RequestValidator::ValidateDate($date)) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }

        $userLogRepo = new UserLogRepository();
        $count = $userLogRepo->FindSubscriptionLogsCount($user_id, $subscription_id, Carbon::parse($date));
        Flight::json($count);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});
Flight::route('GET /users/@user_id/subscriptions/@subscription_id', function ($user_id, $subscription_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }
        $needle = Flight::request()->query['search'] ?? '';
        $page = Flight::request()->query['page'] ?? '1';
        $limit = Flight::request()->query['limit'] ?? '50';

        if (!RequestValidator::ValidatePaginatedRequest($page, $limit)) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindSubscriptionLogs(
            $user_id,
            $subscription_id,
            $needle,
            $page,
            $limit
        );

        if (!$logs) {
            Flight::json(MessagesCenter::E400('Invalid search column'), 400);
        }

        $logDTOs = [];
        foreach ($logs->items() as $log) {
            $logDTOs[] = UserLogDTO::fromModel($log)->GetDTO();
        }

        Flight::json([
            'pagination' => [
                'per_page' => $logs->perPage(),
                'current' => $logs->currentPage(),
                'total' => $logs->lastPage(),
            ],
            'items' => $logDTOs,
        ]);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});
Flight::route('GET /users/@user_id/subscriptions/@subscription_id/usages', function ($user_id, $subscription_id) {
    try {
        if (!AuthHelper::Auth()) {
            Flight::json(MessagesCenter::E401(), 401);

            return;
        }

        $date = Flight::request()->query['date'] ?? Carbon::now();
        $mode = Flight::request()->query['mode'] ?? 'detailed';
        $requestsCount = Flight::request()->query['count'] ?? -1;

        if (!RequestValidator::ValidateUsageRequest($date, $mode, $requestsCount)) {
            Flight::json(MessagesCenter::E400(), 400);

            return;
        }
        $userLogRepo = new UserLogRepository();
        $groupedLogs = $userLogRepo->FindSubscriptionUsages($user_id, $subscription_id, $date);

        $specifiedDate = Carbon::parse($date);
        $thisDate = Carbon::now();
        $lastDay = $specifiedDate->format('Y-m') == $thisDate->format('Y-m') ? $thisDate->day : (int)$specifiedDate->format('t');

        $totalCount = 0;
        $stats = [];
        for ($i = 1; $i <= $lastDay; $i++) {
            $groupedCount = isset($groupedLogs[$i]) ? count($groupedLogs[$i]) : 0;
            if (strtolower($mode) === 'focused' && $groupedCount === 0) {
                continue;
            }
            $totalCount += $groupedCount;
            $stats[] = [
                'date' => $specifiedDate->format('Y-m-') . sprintf('%02d', $i),
                'count' => $groupedCount,
            ];
        }

        Flight::json([
            'usages' => [
                'current' => $totalCount,
                'max' => (int)$requestsCount,
                'percent' => $requestsCount ? (float)number_format(($totalCount * 100) / $requestsCount, 2) : null,
            ],
            'details' => $stats,
        ]);
    } catch (Exception $ex) {
        Flight::json(MessagesCenter::E500(), 500);
    }
});

Flight::start();
