<?php

# Configurations
require "./src/config.php";
require "./src/utils/ErrorMessage.php";

# Database
require "./src/database/Database.php";

# Classes
require "./src/class/JWT.php";
require "./src/class/User.php";
require "./src/class/WebCard.php";

# Exceptions
require "./src/exceptions/AuthorizationInvalidException.php";
require "./src/exceptions/TokenInvalidException.php";
require "./src/exceptions/InvalidEndpointException.php";
require "./src/exceptions/RequestException.php";

# Request and response
require "./src/router/Response.php";
require "./src/router/responses/CreateWebCardResponse.php";
require "./src/router/responses/GetUserInfoResponse.php";
require "./src/router/responses/LoggedUserInfoResponse.php";
require "./src/router/Router.php";

?>