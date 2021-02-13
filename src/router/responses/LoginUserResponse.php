<?php

class LoginUserResponse extends Response {

    protected $is_authenticated = FALSE;

    public function execute(array $url_parameters): array { 

        $request = $this->request;

        $user = User::login($request);

        $response = $user->serialize();
        $token = JWT::encode(["sub" => $user->id]);
        $refresh_token = JWT::encode(["sub" => base64_encode($user->id . $user->username)], "30 days");

        $response["token"] = $token;
        $response["refresh_token"] = $refresh_token;

        return $response;
    }
}

?>