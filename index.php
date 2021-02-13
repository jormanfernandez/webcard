<?php
header ("accept: application/json", true);

require "./src/config.php";
require "./src/database/Database.php";
require "./src/class/JWT.php";
require "./src/exceptions/AuthorizationInvalidException.php";
require "./src/utils/errors.php";

$DATABASE = new Database();
$DATABASE->connect(
    $ENV["connString"],
    $ENV["dbUser"],
    $ENV["dbPassword"]
);

try {

    $Authorization = in_array("HTTP_AUTHORIZATION", $_SERVER) ? $_SERVER["HTTP_AUTHORIZATION"] : NULL;
    $token = NULL;

    if ($Authorization !== NULL && str_starts_with(strtolower($Authorization), "Bearer ")) {
        throw new AuthorizationInvalidException(Error::$TOKEN_INVALID);
    }

    if ($Authorization !== NULL) {
        $token = ltrim($Authorization, "Bearer ");
        $token = JWT::decode($token);

        if (JWT::is_expired($token) || in_array("sub", $token) === FALSE) {
            throw new AuthorizationInvalidException(Error::$TOKEN_EXPIRED);
        }
    }

} catch(Exception $e) {
    $message = $e->getMessage();

    if (strpos(CODE_KEY, $message) === NULL) {
        echo Error::$UNKNOW_ERROR;
    } else {
        echo $message;
    }
}

$DATABASE->close();

?>