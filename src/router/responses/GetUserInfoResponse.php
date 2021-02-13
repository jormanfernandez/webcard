<?php

class GetUserInfoResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $url_parameters): array { 

        $username = $url_parameters["username"];
        $user = new User($username, True);

        if (!empty($user->error)) {
            throw new RequestException($user->error);
        }

        return $user->serialize();
    }
}

?>