<?php

class GetUserInfoResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $url_parameters): array { 

        $username = $url_parameters["username"];
        $user = new User($username, True);

        if (empty($user->error) !== NULL) {
            throw new Exception($user->error);
        }

        return [
            "created_datetime" => $user->created_datetime,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "username" => $user->username,
            "avatar" => $user->avatar,
            "email" => $user->email,
            "id" => $user->id
        ];
    }
}

?>