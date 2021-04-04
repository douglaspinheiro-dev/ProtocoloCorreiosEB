<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));


/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);



$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/


$app->middleware([
    // App\Http\Middleware\ExampleMiddleware::class
    App\Http\Middleware\CorsMiddleware::class
]);

$app->routeMiddleware([
    // 'auth' => App\Http\Middleware\Authenticate::class,
    // 'CorsMiddleware' => App\Http\Middleware\CorsMiddleware::class,
    'jwt.auth' => App\Http\Middleware\JwtMiddleware::class,
    'usuario' => App\Http\Middleware\UsuarioMiddleware::class,
    'grupoUsuario' => App\Http\Middleware\GrupoUsuarioMiddleware::class,
    'tipoDocumento' => App\Http\Middleware\TipoDocumentoMiddleware::class,
    'tipoCorrespondencia' => App\Http\Middleware\TipoCorrespondenciaMiddleware::class,
    'tipoCobranca' => App\Http\Middleware\TipoCobrancaMiddleware::class,
    'endereco' => App\Http\Middleware\EnderecoMiddleware::class,
    'setor' => App\Http\Middleware\EnderecoMiddleware::class,
    'protocoloEntrada' => App\Http\Middleware\EnderecoMiddleware::class,
    'rota' => App\Http\Middleware\RotaMiddleware::class,
    'rotaEndereco' => App\Http\Middleware\RotaEnderecoMiddleware::class,
    'malote' => App\Http\Middleware\MaloteMiddleware::class,
    'maloteDocumento' => App\Http\Middleware\MaloteDocumentoMiddleware::class,
    'correspondencia' => App\Http\Middleware\CorrespondenciaMiddleware::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Barryvdh\Snappy\LumenServiceProvider::class);
class_alias(Barryvdh\Snappy\Facades\SnappyPdf::class, 'PDF');
// class_alias(App\ChromePhp::class, 'ChromePhp');
class_alias(Barryvdh\Snappy\Facades\SnappyImage::class, 'SnappyImage');


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
