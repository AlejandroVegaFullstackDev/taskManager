<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Aquí defines el guard y broker de contraseñas por defecto para tu aplicación.
    | Puedes cambiarlos según lo necesites. En este caso, configuramos que el guard
    | por defecto sea "api" para usar JWT.
    |
    */

    'defaults' => [
        'guard' => 'api', // Usa 'api' (JWT) como guard por defecto
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Define cada guard de autenticación para tu aplicación. Por defecto, se incluye
    | un guard "web" que usa sesiones, y un guard "api" que usará JWT.
    |
    | Soportados: "session", "token", "jwt"
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver'   => 'jwt',   // Importante: define que este guard usa JWT
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Cada guard de autenticación necesita un proveedor de usuarios que indique
    | cómo obtenerlos de la base de datos o sistema de almacenamiento.
    | Aquí usamos el driver "eloquent" con el modelo "App\Models\User".
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configuración de reseteo de contraseñas (si tu app lo usa).
    | "expire" define los minutos de validez del token de reseteo.
    | "throttle" define cuántos segundos hay que esperar para generar otro token.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Cantidad de segundos antes de que caduque la confirmación de contraseña.
    | Por defecto, tres horas (10800 segundos).
    |
    */

    'password_timeout' => 10800,

];
