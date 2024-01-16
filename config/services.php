<?php
$container = new Framework\Container;

// We are binding a value for the database class to the service container
$container->set(\App\Database::class,function (){
    return new \App\Database("localhost","ominas","ominas_dbuser","secret");
});

return $container;