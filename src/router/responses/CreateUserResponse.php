<?php

class CreateUserResponse extends Response {

    protected $is_authenticated = FALSE;

    public function execute(array $url_parameters): array { 

        $request = $this->request;

        $request["id"] = uniqid();
        $user = User::create($request);
        return $user->serialize();
    }
}

?>