<?php

/**
 * @name Router
 *
 * @Author  VIEIRA Diogo
 * @Helper  VIQUERAT Killian
 * @Date    24.09.2019
 */
class Router
{
    /**
     * @var array containt all routes
     */
    private static $routes = array(); // Contiendra la liste des routes
    /**
     * @var string dir containt all our controllers
     */
    private static $dirController="controller";

    /**
     * Method to create dynamics path on our site
     *
     * @param route $route url we want
     * @param  function $function name of controller of the page, add "@" and append name of your method
     *
     * @author Diogo VIEIRA Diogo
     */
    public static function add($route,$function)
    {
        array_push(self::$routes,Array(
            'route' => $route,
            'function' => self::$dirController."/".$function
        ));
    }
    /**
     * check that our url matches with our routes and send to good pages
     *
     * @author Diogo VIEIRA Diogo
     */
    public static function run()
    {
        $idRegex="([0-9]+)";
        $textRegex="([A-Za-z]+)";
        //get current url
        $url = parse_url($_SERVER['REQUEST_URI'])['path'];
        if(substr($url,-1)!="/")
            $url.="/";
        foreach (self::$routes as $route)
        {
            if(substr($route["route"],-1)!="/")
                $route["route"].="/";
            //replace "/", id and text by regex define to top of function
            $regex='^'.str_replace(array("/","id","text"),array("\/",$idRegex,$textRegex),$route["route"]).'$';
            //when route match with url
            if(preg_match(strtolower("#".$regex."#"),strtolower($url),$matches))
            {
                $arraySorted=self::sortArray($route["route"],$matches);
                self::execute($route["function"],$arraySorted);
                exit;
            }
        }
        //when we have nothing in the route
        self::execute(self::$dirController."/HomeController@error",(object)array("error"=>"Error 404 | page not found","message"=>$_SERVER['HTTP_HOST'].$url));
    }
    /**
     * Sort all parameters of route and associated with previous name of the route
     *
     * @param $route route has match with URL
     * @param $params parameters of our URL
     * @return array return an array sorted with associated names
     */
    private static function sortArray($route,$params)
    {
        //we drop first data
        $params=array_slice($params, 1);
        $route=explode("/",$route);
        $arraySorted=array();
        $iParams=0;
        //search on the route the text "id" or "text" and before data is associated with value of params
        for($iRoute=0;$iRoute<count($route);$iRoute++)
            if($route[$iRoute]=="id" || $route[$iRoute]=="text")
                $arraySorted=array_merge($arraySorted,array($route[ ($iRoute==0 ? "1" : $iRoute)-1 ]=>$params[ $iParams++ ]));

        return $arraySorted;
    }
    /**
     * call method of specific class with parameters when it exists
     *
     * @param $function function of route (example "HomeController@error")
     * @param $param array with all datas of our URL
     */
    private static function execute($function,$param){
        $controller=explode('@',$function);
        $class=explode('/', $controller[0])[1];
        $controller[0]=$controller[0].'.php';
        include("$controller[0]");

        $method=$controller[1];
        if( !empty($param) || count($param)>=1 )
            //convert $parm to object for easier use
            $class::$method((object)$param);
        else
            $class::$method();
    }

}