<?php

include("model/router.php");

class RouteController extends Controller
{
    public static function addRoutes()
    {
        router::add("/", "HomeController@index");
        router::add("/home", "HomeController@index");
        router::add("/exercise/id", "HomeController@exercise");
        router::add("/exercise/id/modif", "HomeController@modif");
        router::add("/manage", "ManageController@index");
        router::add("/error", "HomeController@error");

        router::run();
    }

}