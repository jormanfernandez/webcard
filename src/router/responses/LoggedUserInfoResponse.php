<?php

class LoggedUserInfoResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $url_parameters): array { 
        return $this->user->serialize();
    }
}

?>