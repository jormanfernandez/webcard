<?php
header ("accept: application/json", true);
header ("content-type: application/json", true);

require "./src/utils/imports.php";

set_error_handler(function($errno, $errstr, $errfile, $errline ){
    global $ENV;

    $text = $errstr;

    if ($ENV["debug"]) {
        $text = "{$text} | {$errfile} | {$errline}";
    }

    $message = json_encode([
        MESSAGE_KEY => $text,
        CODE_KEY => $errno
    ]);
    throw new RequestException($message);
});

JWT::setup($ENV["JWT_KID"], $ENV["JWT_SIGN"]);

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

    if ($authorization !== NULL && !str_starts_with(strtolower($authorization), "bearer ")) {
        throw new AuthorizationInvalidException(ErrorMessage::$TOKEN_INVALID);
    }

    if ($authorization !== NULL) {
        $token = str_replace("Bearer ", "", $authorization);
        $token = JWT::decode($token);

        if (JWT::is_expired($token)) {
            throw new AuthorizationInvalidException(ErrorMessage::$TOKEN_EXPIRED);
        }

        $uid = $token["sub"];
    }

    http_response_code(200);
    echo Router::go($uid);

} catch(Exception $e) {

    $message = $e->getMessage();

    if (strpos($message, CODE_KEY) === FALSE) {
        http_response_code(500);
        echo str_replace("{error_message}", $message, ErrorMessage::$UNKNOW_ERROR);
    } else {
        http_response_code(400);
        echo $message;
    }
}

$DATABASE->close();

?>