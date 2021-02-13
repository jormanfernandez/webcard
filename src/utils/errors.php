<?php

define("CODE_KEY", "errorCode");
define("MESSAGE_KEY", "errorMessage");

class Error {

    public static $UNKNOW_ERROR = json_decode([
        MESSAGE_KEY => "Unknown Error",
        CODE_KEY => "err001"
    ]);

    public static $TOKEN_INVALID = json_decode([
        MESSAGE_KEY => "Token invalid",
        CODE_KEY => "err002"
    ]);

    
    public static $USER_DOES_NOT_EXISTS = json_decode([
        MESSAGE_KEY => "User does not exists",
        CODE_KEY => "err003"
    ]);
    
    public static $TOKEN_EXPIRED = json_decode([
        MESSAGE_KEY => "The token is expired",
        CODE_KEY => "err003"
    ]);

?>