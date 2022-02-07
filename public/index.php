
<?php
const LOGGING_START = true;

require __DIR__ . '/../init.php';

Flight::map('notFound', function(){
    http_response_code(404);
    exit('');
});

Flight::route('POST /logs/admins', function () {
    try {
        $tokenRepo = new AccessTokenRepository();
        if (!$tokenRepo->AuthAccessToken(AuthHelper::GetBearerToken())){
            http_response_code(401);
            exit('');
        }

        $adminLogRepo = new AdminLogRepository();
        ray(Flight::request()->data);
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
        ray($ex->getMessage());
        exit('');
    }
});

Flight::route('POST /logs/users', function () {
    try {
        ray(AuthHelper::GetBearerToken());
        $tokenRepo = new AccessTokenRepository();

        if (!$tokenRepo->AuthAccessToken(AuthHelper::GetBearerToken())){
            http_response_code(401);
            exit('');
        }

        $userLogRepo = new UserLogRepository();
        $userLogRepo->Create([
            'personal_token_id' => Flight::request()->data->personal_token_id,
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

Flight::start();	