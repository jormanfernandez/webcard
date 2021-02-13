<?php
require "../Response.php";
require "../../class/User.php";

class GetUserInfoResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $request, array $url_parameters): array { 

        $pk = $url_parameters["pk"];

        $user = new User($pk);

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