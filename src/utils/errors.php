<?php

define("CODE_KEY", "errorCode");
define("MESSAGE_KEY", "errorMessage");

class Error {

    public static $UNKNOW_ERROR;
    public static $TOKEN_INVALID;
    public static $USER_DOES_NOT_EXISTS;
    public static $TOKEN_EXPIRED;
    public static $URL_NOT_FOUND;

    public static function setup() {
        /**
         * Due to PHP limitations, we set up the response codes here
         */

        self::$UNKNOW_ERROR = json_encode([
            MESSAGE_KEY => "Unknown Error",
            CODE_KEY => "err001"
        ]);
    
        self::$TOKEN_INVALID = json_encode([
            MESSAGE_KEY => "Token invalid",
            CODE_KEY => "err002"
        ]);
        
        self::$USER_DOES_NOT_EXISTS = json_encode([
            MESSAGE_KEY => "User does not exists",
            CODE_KEY => "err003"
        ]);
        
        self::$TOKEN_EXPIRED = json_encode([
            MESSAGE_KEY => "The token is expired",
            CODE_KEY => "err004"
        ]);
    
        self::$URL_NOT_FOUND = json_encode([
            MESSAGE_KEY => "The direction was not found",
            CODE_KEY => "err005"
        ]);
    }
}

Error::setup();

?>
