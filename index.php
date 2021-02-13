<?php
header ("accept: application/json", true);

require "./src/utils/imports.php";

$DATABASE = new Database();
$DATABASE->connect(
    $ENV["connString"],
    $ENV["dbUser"],
    $ENV["dbPassword"]
);

try {

    $Authorization = in_array("HTTP_AUTHORIZATION", $_SERVER) ? $_SERVER["HTTP_AUTHORIZATION"] : NULL;
    $token = NULL;
    $uid = NUlL;

    if ($Authorization !== NULL && str_starts_with(strtolower($Authorization), "Bearer ")) {
        throw new AuthorizationInvalidException(ErrorMessage::$TOKEN_INVALID);
    }

    if ($Authorization !== NULL) {
        $token = ltrim($Authorization, "Bearer ");
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