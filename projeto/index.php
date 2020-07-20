<?php

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(ROOT);

$router->namespace("Source\App");

$router->group(null);
$router->get("/", "Web:home");

$router->get("/produtos", "Web:product");

$router->group("form-produto-edit");
$router->get("/", "Web:productEdit");
$router->post("/", "Web:productEditPost");
$router->get("/{filter}", "Web:productEdit");

$router->group("form-produto");
$router->get("/", "Web:productAdd");
$router->post("/", "Web:productAddPost");

$router->group("form-venda");
$router->get("/", "Web:saleView");
$router->post("/", "Web:saleAdd");

$router->group("produtos-excluidos");
$router->get("/", "Web:excluidosView");
$router->post("/delete", "Web:excluidosDelete", "form.delete");
$router->post("/restore", "Web:excluidosRestore", "form.restore");

$router->dispatch();

if($router->error()){
    var_dump($router->error());
}