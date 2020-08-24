<?php

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE);

//Controllers
$router->namespace("Source\App");

$router->group(null);
$router->get("/","Web:insert");
$router->post("/","Web:insert");
$router->get("/{filter}", "Web:insert");

//insert
$router->group("insert");
$router->get("/","Web:insert");

//update
$router->group("update");
$router->get("/","Web:update");

//list
$router->group("list");
$router->get("/","Web:list");

//list limite 20
$router->group("list20");
$router->get("/","Web:list20");

//erros
$router->group("error");
$router->get("/{errcode}", "Web:error");

$router->dispatch();

if ($router->error()){
    $router->redirect("/error/{$router->error()}");
} 