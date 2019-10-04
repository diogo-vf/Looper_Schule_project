<?php
require 'model/HomeModel.php';

/**
 * Class HomeController
 *
 * @authors Diogo Vieira and Damien Jakob
 * @date 27.09.2019
 */
class HomeController extends Controller
{
    static function index()
    {
        return View::render("Home");
    }
}