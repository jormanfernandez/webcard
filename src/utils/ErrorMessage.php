<?php

define("CODE_KEY", "errorCode");
define("MESSAGE_KEY", "errorMessage");

class ErrorMessage {

    public static $UNKNOW_ERROR;
    public static $TOKEN_INVALID;
    public static $USER_DOES_NOT_EXISTS;
    public static $TOKEN_EXPIRED;
    public static $URL_NOT_FOUND;
    public static $INVALID_PARAMETER;
    public static $INVALID_THEMECARD;
    public static $INVALID_METHOD;

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

        self::$INVALID_PARAMETER = json_encode([
            MESSAGE_KEY => "An invalid parameter was sent",
            CODE_KEY => "err006"
        ]);

        self::$INVALID_THEMECARD = json_encode([
            MESSAGE_KEY => "An invalid theme was sent",
            CODE_KEY => "err007"
        ]);

        self::$INVALID_METHOD = json_encode([
            MESSAGE_KEY => "The method used is invalid",
            CODE_KEY => "err008"
        ]);
    }
}

ErrorMessage::setup();

?>
