<?php

require __DIR__ . '/../init.php';

Flight::map('notFound', function(){
    http_response_code(404);
    exit('');
});

Flight::route('GET /', function () {
    Product::query()->create([
        'name' => 'Something'
    ]);

    exit('done!');
});

Flight::start();