<?php
$container = new Framework\Container;

/**
 * Config the Container to return a specific object by adding a class to its registry here.
 */

// We are binding a value for the database class to the service container
$container->set(\App\Database::class,function (){
    return new \App\Database($_ENV["DB_HOST"],$_ENV["DB_NAME"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"]);
});

/**
 * Adding an entry to the containers registry for the Interface
 * -> Decouple the Dispatcher from a concrete Class.
 * Return a specific Template Engines, because we can not instantiate an Interface
 */
$container->set(Framework\TemplateViewerInterface::class, function() {
    return new Framework\MVCTemplateViewer();
});

return $container;