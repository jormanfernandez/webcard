<?php
require "../Response.php";

class LoggedUserInfoResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $request, array $url_parameters): array { 
        return [
            "created_datetime" => $this->user->created_datetime,
            "first_name" => $this->user->first_name,
            "last_name" => $this->user->last_name,
            "username" => $this->user->username,
            "avatar" => $this->user->avatar,
            "email" => $this->user->email,
            "id" => $this->user->id
        ];
    }
}

?>