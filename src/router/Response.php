<?php

class Response {
    
    protected $is_authenticated = FALSE;
    protected $user = NULL;

    public function process(?string $uid, array $url_parameters = []): string {
        /**
         * Abstract service to use in the different response types. Validating if the user needs to be authenticated
         * and handling the request to process with the inner method
         * 
         * @param string $uid user id of the one making the request
         */

        if ($this->is_authenticated) {
            $this->validate_user($uid);
        }

        $request = $this->get_params();
        $response = $this->execute($request, $url_parameters);

        return json_encode($response);
    }

    public function get_params() {
        /**
         * Handles the get of the params for the specific request
         * 
         * @return array
         */
        return [];
    }

    public function execute(array $request, array $url_parameters): array {
        /**
         * Execute a request in the other services
         * 
         * @param array $request parameters processed for the request
         * @param array $url_parameters parameters extracted from the url
         * 
         * @return array 
         */
        return [];
    }

    private function validate_user(?string $uid): void {
        /**
         * For the response, checks out the user id and add it to the instance
         * attribute, else throws an exception
         * 
         * @param string $uid
         */

        if(empty($uid))  {
            throw new AuthorizationInvalidException(ErrorMessage::$USER_DOES_NOT_EXISTS);
        }

        $this->user = new User($uid);

        if (empty($this->user->error) === FALSE) {
            throw new AuthorizationInvalidException(ErrorMessage::$USER_DOES_NOT_EXISTS);
        }
    }
}

?>