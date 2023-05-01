<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(dirname(__DIR__)))->bootstrap();
date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(dirname(__DIR__));
$app->withFacades();
$app->configure('app');
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->routeMiddleware([ 'auth' => App\Http\Middleware\Authenticate::class, ]);
$app->router->group([ 'namespace' => 'App\Http\Controllers', ], function ($router) {
    require __DIR__.'/../routes/api.php';
});

return $app;
