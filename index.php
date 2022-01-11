<?php

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;
$router = new Router(URL_BASE);


/**
 * Controllers
 */
$router->namespace("Source\App");


/**
 * WEB
 * home
 */
$router->group(null);

// rotas para controle de login
$router->get("/", "Web:login");
$router->post("/executeLogin", "Web:executeLogin");

// rotas para controle de registro
$router->get("/signup", "Web:signup");
$router->post("/registerUser", "Web:registerUser");

// rotas para controle de logout
$router->get("/logout", "Web:logout");

// rotas principal -> homePage
$router->get("/home", "Web:home");

// rotas para registro de usuários

// rota para requisição de recuperação de conta
$router->get("/request-recover", "Web:requestRecover");
$router->post("/requestRecoverLogin", "Web:requestRecoverLogin");

// rota de redefinição de senha
$router->get("/redefine-password/{email}/{key}", "Web:redefinePassword");
$router->post("/resetUserPassword", "Web:resetUserPassword");

// rotas de sala
$router->get("/new-room", "Web:newRoom");
$router->post("/createNewRoom", "Web:createNewRoom");

$router->get("/manage-rooms", "Web:manageAllRooms");
$router->post("/searchRoomByKeyword", "Web:searchRoomByKeyword");
$router->post("/updateRoom", "Web:updateRoom");
$router->post("/cancelReservation", "Web:cancelReservation");
$router->post("/manageRooms", "Web:manageRooms");
$router->get("/edit-room", "Web:editRoom");


// rotas para reserva de sala
$router->get("/my-reservations", "Web:myReservations");
$router->get("/new-reservation", "Web:newReservation");
$router->post("/listAllUserReservations", "Web:listAllUserReservations");
$router->post("/createRoomReservation", "Web:createRoomReservation");
$router->post("/updateRoomReservation", "Web:updateRoomReservation");
$router->post("/searchReservationByKeyword", "Web:searchReservationByKeyword");
$router->post("/checkDateAvailability", "Web:checkDateAvailability");
$router->post("/manageRoomReservations", "Web:manageRoomReservations");
$router->post("/searchRoomsForReservation", "Web:searchRoomsForReservation");


// rotas de recursos
$router->get("/manage-resources", "Web:manageResources");
$router->post("/listResources", "Web:listResources");
$router->post("/roomResourcesList", "Web:roomResourcesList");
$router->post("/createNewResource", "Web:createNewResource");
$router->post("/updateResource", "Web:updateResource");
$router->post("/removeRoomResources", "Web:removeRoomResources");
$router->post("/searchResourceBbyKeyword", "Web:searchResourceBbyKeyword");



/**
 * ERRORS
 */
$router->group("ops");
$router->get("/{errcode}", "Web:error");

// executa o despacho de rotas
$router->dispatch();

if($router->error()){
    // var_dump($router->error());
    $router->redirect("/ops/{$router->error()}");
}




