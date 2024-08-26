<?php

require __DIR__.'/vendor/autoload.php';

use Spatie\Permission\Middlewares\RoleMiddleware;

$middleware = new RoleMiddleware();

echo "Class loaded successfully";
