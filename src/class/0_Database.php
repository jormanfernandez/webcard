<?php

class Database {

    private $conn_string;
    private $username;
    private $password;
    private $conn = NULL;

    private $stm;

    function connect(string $conn_string, string $username, string $password): void {
        /**
         * Connects to the database to use in the environment
         * 
         * @param $conn_string Strign to connect to the database
         * @param $username Username to give permissions
         * @param $password Password to access the database
         */
        $this->conn_string = $conn_string;
        $this->username = $username;
        $this->password = $password;

        $this->createPDO();
    }
    
    function createPDO(): void {
        /**
         * With the inner values set, we create the connection to the pdo instance
         */
        
        $this->conn = new PDO(
            $this->conn_string, 
            $this->username, 
            $this->password
        );
        
    }

    function query(string $query, array $params = []): Database {
        /**
         * Executes a query in the database depending on the respective parameters received
         * 
         * @param $query Query to be executed
         * @param $params parameters to be added as a prepared statement
         */

        $response = [
            "success" => FALSE,
            "data" => ""
        ];

        $this->stm = $this->conn->prepare(
            $query
        );

        if ( count($params) > 0 ) {
            $this->bindParameters($params);
        }

        return $this;
    }

    function execute(): array {
        /**
         * Executes a query stored in the prepared statement
         * 
         * @return array bool, string
         */

        $response = [
            "success" => FALSE,
            "message" => ""
        ];
        
        try {

            $this->stm->execute();
            $response["success"] = True;

        } catch ( Exception $e ) {
            $response["message"] = $e->getMessage();
        }

        return $response;
    }

    function fetch(): array {
        /**
         * From the stm prepared statement, executes the function fetchAll
         * to return any value stored from the previous executed query
         * 
         * @return array
         */

         return $this->stm->fetchAll();
    }

    function bindParameters($params): void {
        /**
         * Using the bindParam feature of prepared statements 
         * from pdo, we attach the key value pair from params
         * to the prepared statement
         * 
         * @param $params array
         */

        foreach($params as $key => $value) {
            $this->stm->bindParam($key, $value);
        }
    }

    function close(): void {
        /**
         * We close the connection to the database by destroying the 
         * pdo instance
         */
        $this->conn = NULL;
    }
}

?>