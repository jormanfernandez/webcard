<?php

require "../utils/errors.php";

class User {

    public $id = "";
    public $username = "";
    public $created_datetime = "";
    public $first_name = "";
    public $last_name = "";
    public $email = "";
    public $avatar = "";

    public $error = "";

    private $table = "user_app";

    public function __construct(string $id) {
        /**
         * Connects to the user platform to lookup details or update it
         * 
         * @param string $id Identifier for the user
         */
        global $DATABASE;

        $this->id = $id;

        $query = "SELECT 
            id, 
            username, 
            created_datetime,
            first_name,
            last_name,
            email,
            avatar
        FROM {$this->table}
        WHERE {$this->table}.id = :id";

        $DATABASE->query($query, [
            ":id" => $this->id
        ]);

        $response = $DATABASE->execute();

        if ( $response["success"] === FALSE) {
            $this->error = $response["data"];
            return;
        }

        $results = $DATABASE->fetch();

        if (count($results) < 1) {
            $this->error = Error::$USER_DOES_NOT_EXISTS;
            return;
        }

        $results = $results[0];
        $this->created_datetime = $results["created_datetime"];
        $this->first_name = $results["first_name"];
        $this->last_name = $results["last_name"];
        $this->username = $results["username"];
        $this->avatar = $results["avatar"];
        $this->email = $results["email"];
        $this->error = "";
    }

    public function update(): array {
        /**
         * With the id selected, will change the other values that the 
         * user has in the instance
         */
        global $DATABASE;


        $query = "UPDATE 
            {$this->table} 
        SET 
            created_datetime = :created_datetime,
            first_name = :first_name,
            last_name = :last_name,
            username = :username,
            avatar = :avatar,
            email = :email
        WHERE {$this->table}.id = :id";

        $DATABASE->query($query, [
            ":created_datetime" => $this->created_datetime,
            ":first_name" => $this->first_name,
            ":last_name" => $this->last_name,
            ":username" => $this->username,
            ":avatar" => $this->avatar,
            ":email" => $this->email,
            ":id" => $this->id
        ]);

        $response = $DATABASE->execute();

        return $response;
    }
}

?>