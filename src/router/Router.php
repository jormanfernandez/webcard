<?php

require "../router/responses/GetUserInfoResponse.php";
require "../utils/errors.php";

class Router {
    
    private static $routes = [
        "/api/user/info/" => "GetUserInfoResponse"
    ];

    public static function go(string $uid): string { 
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
            $endpoint = str_replace("/", "\/", $route);

            $pattern = "/{$endpoint}/i";
            $match = [];

            $found = preg_match($pattern, $_SERVER["REQUEST_URI"], $match);
            if ($found !== 1) {
                continue;
            }

            $url_parameters = $match;
            $handler = $class;
            break;
        }

        if ($handler === NULL) {
            throw new InvalidEndpointException(Error::$URL_NOT_FOUND);
        }

        $handler = new $handler();

        return $handler->process($uid, $url_parameters);
    }

}

?>