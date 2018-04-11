<?php

namespace App\Classes\TDG;

use PDO;

class MySQLConnection {

    private $conn;

    public function __construct() {
        $connectionString =
          'mysql:host=localhost;dbname=conushop;charset=utf8';
        $this->conn = new PDO(
          $connectionString,
          env('DB_USERNAME'),
          env('DB_PASSWORD')
        );
    }

    public function query($query, $bindValues) {
        $localConn = $this->conn;


        //change path according to current directory
        $current = getcwd();
        $pos = strpos( $current, 'laravel');
        $new = substr($current, 0 , 16);
        $new = $new.'laravel\docker\migration';


        //verify OS before running script
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            exec("python shadow.py $query");
        else
            exec("python shadow.py $query");
        $stmt = $localConn->prepare($query);


        //We bind the values to make sure we are protected from injections
        foreach ($bindValues as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            return false;

            die($e->getMessage());
        }
    }

    public function directQuery($query) {
        $localConn = $this->conn;

        $stmt = $localConn->prepare($query);

        //change path according to current directory
        $current = getcwd();
        $pos = strpos( $current, 'laravel');
        $new = substr($current, 0 , 16);
        $new = $new.'laravel\docker\migration';
        chdir($new);

        //verify OS before running script
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            exec("python shadow.py $query");
        else
            exec("python shadow.py $query");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPDOConnection() {
        return $this->conn;
    }

}
