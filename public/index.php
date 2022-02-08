
<?php
const LOGGING_START = true;

require __DIR__ . '/../init.php';

Flight::map('notFound', function(){
    http_response_code(404);
    exit('');
});

Flight::route('POST /logs/admins', function () {
    try {
        if (!AuthHelper::Auth()){
            http_response_code(401);
            exit('');
        }

        $adminLogRepo = new AdminLogRepository();
        $adminLogRepo->Create([
            'access_token_id' => Flight::request()->data->access_token_id,
            'url' => Flight::request()->data->url,
            'ip' => Flight::request()->data->ip,
            'method' => Flight::request()->data->method,
            'user_agent' =>Flight::request()->data->user_agent,
        ]);
        http_response_code(201);
        exit('');
    }
    catch (Exception $ex){
        http_response_code(500);
        exit('');
    }
});
Flight::route('GET /logs/admins/', function (){
    try {
        if (!AuthHelper::Auth()){
            http_response_code(401);
            exit('');
        }

        $needle = Flight::request()->query['search']?? '';

        // Find solution to pagination (doesnt work now)
        $page = Flight::request()->query['page']?? 1;
        $limit= Flight::request()->query['limit']?? 50;

        $adminLogRepo = new AdminLogRepository();
        $logs = $adminLogRepo->FindAll(
            $needle,
            $page,
            $limit
        );

        http_response_code(200);
        Flight::json($logs);
        exit('');
    }
    catch (Exception $ex){
        ray($ex->getMessage());
        http_response_code(500);
        exit('');
    }
});


Flight::route('POST /logs/users', function () {
    try {
        if (!AuthHelper::Auth()){
            http_response_code(401);
            exit('');
        }

        $userLogRepo = new UserLogRepository();
        $userLogRepo->Create([
            'subscription_id' => Flight::request()->data->subscription_id,
            'url' => Flight::request()->data->url,
            'ip' => Flight::request()->data->ip,
            'method' => Flight::request()->data->method,
            'user_agent' =>Flight::request()->data->user_agent,
        ]);
        http_response_code(201);
        exit('');
    }
    catch (Exception $ex){
        ray($ex->getMessage());
        http_response_code(500);
        exit('');
    }
});
Flight::route('GET /logs/users/@subscription_id/count', function ($subscription_id) {
    try {
        if (!AuthHelper::Auth()){
            http_response_code(401);
            exit('');
        }

        $userLogRepo = new UserLogRepository();
        $count = $userLogRepo->FindLogsBySubscriptionCount($subscription_id,\Carbon\Carbon::now());
        http_response_code(200);
        Flight::json($count);
        exit('');
    }
    catch (Exception $ex){
        http_response_code(500);
        exit('');
    }
});
Flight::route('GET /logs/users/@subscription_id/', function ($subscription_id){
    try {
        if (!AuthHelper::Auth()){
            http_response_code(401);
            exit('');
        }
        $needle = Flight::request()->query['search']?? '';

        // Find solution to pagination (doesnt work now)
        $page = Flight::request()->query['page']?? 1;
        $limit= Flight::request()->query['limit']?? 50;

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindLogsBySubscription($subscription_id,
            $needle,
            $page,
            $limit
        );

        http_response_code(200);
        Flight::json($logs);
        exit('');
    }
    catch (Exception $ex){
        http_response_code(500);
        exit('');
    }
});
Flight::route('GET /logs/users/', function (){
    try {
        if (!AuthHelper::Auth()){
            http_response_code(401);
            exit('');
        }

        $needle = Flight::request()->query['search']?? '';

        // Find solution to pagination (doesnt work now)
        $page = Flight::request()->query['page']?? 1;
        $limit= Flight::request()->query['limit']?? 50;

        $userLogRepo = new UserLogRepository();
        $logs = $userLogRepo->FindAll(
            $needle,
            $page,
            $limit
        );

        http_response_code(200);
        Flight::json($logs);
        exit('');
    }
    catch (Exception $ex){
        http_response_code(500);
        exit('');
    }
});




Flight::start();	