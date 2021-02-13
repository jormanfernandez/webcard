<?php

class CreateUserResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $url_parameters): array { 

        $request = $this->request;
        $params = [];

        
        
        return [];
    }
}

?>