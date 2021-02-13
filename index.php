<?php
header ("accept: application/json", true);

require "./src/utils/imports.php";

set_error_handler(function($errno, $errstr, $errfile, $errline ){
    $message = json_encode([
        MESSAGE_KEY => $errstr,
        CODE_KEY => $errno
    ]);
    throw new RequestException($message);
});

$DATABASE = new Database();
$DATABASE->connect(
    $ENV["connString"],
    $ENV["dbUser"],
    $ENV["dbPassword"]
);

try {

    $authorization = isset($_SERVER["HTTP_AUTHORIZATION"]) ? $_SERVER["HTTP_AUTHORIZATION"] : NULL;
    $token = NULL;
    $uid = NUlL;

    if ($authorization !== NULL && str_starts_with(strtolower($authorization), "Bearer ")) {
        throw new AuthorizationInvalidException(ErrorMessage::$TOKEN_INVALID);
    }

    if ($authorization !== NULL) {
        $token = ltrim($authorization, "Bearer ");
        $token = JWT::decode($token);

        if (JWT::is_expired($token) || in_array("sub", $token) === FALSE) {
            throw new AuthorizationInvalidException(ErrorMessage::$TOKEN_EXPIRED);
        }

        $uid = $token["sub"];
    }

    echo Router::go($uid);

} catch(Exception $e) {
    $message = $e->getMessage();

    if (strpos(CODE_KEY, $message) === NULL) {
        echo ErrorMessage::$UNKNOW_ERROR;
    } else {
        echo $message;
    }
}

$DATABASE->close();

?>