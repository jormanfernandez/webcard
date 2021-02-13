<?php

class Database {

    private $conn_string;
    private $username;
    private $password;
    private $conn = NULL;

    private $stm;

    public function connect(string $conn_string, string $username, string $password): void {
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
    
    public function createPDO(): void {
        /**
         * With the inner values set, we create the connection to the pdo instance
         */
        
        $this->conn = new PDO(
            $this->conn_string, 
            $this->username, 
            $this->password
        );

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }

    public function query(string $query, array $params = []): Database {
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

    public function execute(): void {
        /**
         * Executes a query stored in the prepared statement
         */


        try {

            $this->stm->execute();
            $response["success"] = TRUE;

        } catch ( PDOException $e ) {
            $message = $e->getMessage();
            throw new RequestException($message);
        }
    }

    public function commit() {
        /**
         * Handles a commit change to the database
         */

         $this->conn->commit();
    }

    public function fetch(): array {
        /**
         * From the stm prepared statement, executes the function fetchAll
         * to return any value stored from the previous executed query
         * 
         * @return array
         */

         return $this->stm->fetchAll();
    }

    public function bindParameters($params): void {
        /**
         * Using the bindParam feature of prepared statements 
         * from pdo, we attach the key value pair from params
         * to the prepared statement
         * 
         * @param $params array
         */

        foreach($params as $key => $value) {

            $data_type = PDO::PARAM_STR;

            $param_type = gettype($value);
            
            switch($param_type) {
                case "integer":
                case "double":
                    $data_type = PDO::PARAM_INT;
                break;
                
                case "boolean":
                    $data_type = PDO::PARAM_BOOL;
                break;

                case "NULL":
                    $data_type = PDO::PARAM_NULL;
                break;

                default:
                    $data_type = PDO::PARAM_STR;
            }

            $this->stm->bindValue($key, $value, $data_type);
        }
    }

    public function close(): void {
        /**
         * We close the connection to the database by destroying the 
         * pdo instance
         */
        $this->conn = NULL;
    }
}

?>