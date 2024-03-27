<?php
class Connection
{
    private $host = "localhost";
    private $username = "root";
    private $password = "199716";
    private $database = "Tasks";
    private $con;



    //  ----------------------------------------------------------------
    // the constructor is called when a new object is created and handle database connection
    public function __construct()
    {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
            $this->con = new PDO($dsn, $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // ----------------------------------------------------------------
    // this function is called whenever you want to select data into the database
    public function Select($query, $params = [])
    {
        $data = [];
        try {
            $stmt = $this->con->prepare($query);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            echo "an error occured while executing the query: " . $e->getMessage();
        }
        return $data;
    }
    // --------------------------------------------------------------------
    // this function is called whenever you want to insert, update or delete data in database
    public function Execute($query, $params = [])
    {
        try {
            $stmt = $this->con->prepare($query);
            $stmt->execute($params);
        } catch (PDOException $e) {
            echo "an error occured while executing the query: " . $e->getMessage();
        }
        return $stmt->rowCount();
    }
    //  ----------------------------------------------------------------
    // this function is called whenver you want to close the database connection
    public function close()
    {
        $this->con = null;
    }
}
