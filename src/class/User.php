<?php

class User {

    public $id = "";
    public $username = "";
    public $created_datetime = "";
    public $first_name = "";
    public $last_name = "";
    public $email = "";
    public $avatar = "";
    public $validated = FALSE;

    public $error = "";

    private $table = "user_app";
    private static $TABLE = "user_app";

    public function __construct(?string $id, bool $by_username = False) {
        /**
         * Connects to the user platform to lookup details or update it
         * 
         * @param string $id Identifier for the user
         */

        if (empty($id)) {
            return;
        }

        global $DATABASE;

        $search_by = $by_username ? "username" : "id";

        $query = "SELECT 
            id, 
            username, 
            created_datetime,
            first_name,
            last_name,
            email,
            avatar
        FROM {$this->table}
        WHERE {$this->table}.{$search_by} = :id";

        $DATABASE->query($query, [
            ":id" => $id
        ]);

        $response = $DATABASE->execute();

        if ( $response["success"] === FALSE) {
            $this->error = $response["data"];
            return;
        }

        $results = $DATABASE->fetch();

        if (count($results) < 1) {
            $this->error = ErrorMessage::$USER_DOES_NOT_EXISTS;
            return;
        }

        $results = $results[0];
        $this->created_datetime = $results["created_datetime"];
        $this->first_name = $results["first_name"];
        $this->last_name = $results["last_name"];
        $this->username = $results["username"];
        $this->avatar = $results["avatar"];
        $this->validated = $results["validated"] == 1;
        $this->email = $results["email"];
        $this->id = $results["id"];
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

    public function serialize(): array {
        /**
         * Returns an associative array of all the field that the user has
         * 
         * @return array
         */

        $info = [
            "created_datetime" => $this->created_datetime,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "username" => $this->username,
            "avatar" => $this->avatar,
            "validated" => $this->validated,
            "email" => $this->email,
            "id" => $this->id
        ];

        return $info;
    }

    public static function get_all(): array {
        /**
         * As test purpose, we select all the users in the database
         */
        global $DATABASE;

        $table = self::$TABLE;

        $query = "SELECT 
            id
        FROM {$table}";

        $DATABASE->query($query);
        
        $response = $DATABASE->execute();

        if ( $response["success"] === FALSE ) {
            throw new RequestException($response["data"]);
        }

        $rows = $DATABASE->fetch();
        $users = [];

        foreach($rows as $row) {
            $user = new User($row["id"]);
            array_push($users, $user->serialize());
        }

        return $users;
    }

    public static function create(array $parameters): User {
        /**
         * Creates a user in the database and returns the instance of the user created
         * 
         * @param array $parameters Associative array of the parameters to be inserted as a new user
         * 
         * @return User
         */

        $user = new User(NULL);



        return $user;
    }

}

?>