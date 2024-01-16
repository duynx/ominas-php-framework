<?php
$container = new Framework\Container;

// We are binding a value for the database class to the service container
$container->set(\App\Database::class,function (){
    return new \App\Database($_ENV["DB_HOST"],$_ENV["DB_NAME"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"]);
});

return $container;