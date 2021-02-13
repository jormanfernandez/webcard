<?php

class CreateWebCardResponse extends Response {

    protected $is_authenticated = TRUE;

    public function execute(array $url_parameters): array { 

        $default_title = "My WebCard";
        $default_subtitle = "";

        $request = $this->request;

        $params = [
            "title" => $request["title"] && is_string($request["title"]) ? $request["title"] : $default_title,
            "subtitle" => $request["subtitle"] && is_string($request["subtitle"]) ? $request["subtitle"] : $default_subtitle,
        ];
        
        return [];
    }
}

?>