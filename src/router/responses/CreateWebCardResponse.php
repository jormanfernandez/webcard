<?php

class CreateWebCardResponse extends Response {

    protected $is_authenticated = TRUE;

    public function get_params(): array {
        /**
         * Search for the params
         * 
         * @param title
         * @param subtitle
         */

        $default_title = "My WebCard";
        $default_subtitle = "";

        $params = [
            "title" => $_POST["title"] && is_string($_POST["title"]) ? $_POST["title"] : $default_title,
            "subtitle" => $_POST["subtitle"] && is_string($_POST["subtitle"]) ? $_POST["subtitle"] : $default_subtitle,
        ];

        return $params;
    }

    public function execute(array $request, array $url_parameters): array { 
        return [];
    }
}

?>