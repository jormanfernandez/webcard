<?php

class GetAllUsersTest extends Response {

    protected $is_authenticated = FALSE;

    public function execute(array $url_parameters): array { 
        /**
         * Search for all the users in the application
         */
        $users = User::get_all();
        return $users;
    }
}

?>