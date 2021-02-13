<?php

class Router {
    
    private static $routes = [
        "/api/user/info/" => [
            "method" => "get",
            "handler" => "LoggedUserInfoResponse"
        ],
        "/api/user/(?P<username>[^/]+)/" => [
            "method" => "get",
            "handler" => "GetUserInfoResponse"
        ]
    ];

    public static function go(?string $uid): string { 
        /**
         * Handles the received request
         * 
         * @param $uid User id in case there's any
         * 
         * @return string Json coded string of the result of the request 
         */

        $handler = NULL;
        $url_parameters = [];

        foreach(self::$routes as $route => $class) {

            if (strtolower($_SERVER['REQUEST_METHOD']) !== $class["method"]) {
                continue;
            }

            $endpoint = str_replace("/", "\/", $route);

            $pattern = "/{$endpoint}/i";
            $match = [];

            $found = preg_match($pattern, $_SERVER["REQUEST_URI"], $match);
            if ($found !== 1) {
                continue;
            }

            $url_parameters = $match;
            $handler = $class["handler"];
            break;
        }

        if ($handler === NULL) {
            throw new InvalidEndpointException(ErrorMessage::$URL_NOT_FOUND);
        }

        $handler = new $handler();

        return $handler->process($uid, $url_parameters);
    }

}

?>