<?php

namespace App\Classes\TDG;
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../../../vendor/mongodb/mongodb/src/Client.php';
require __DIR__ . '/../../../vendor/mongodb/mongodb/src/Model/BSONArray.php';

//\vendor\mongodb\mongodb\src\Client.php;
use Hash;
use MongoDB\Client;

class UserCatalogTDG {

    public $conn;
    public $mongoClient;
    public $db;
    public  $list_users;



    public function __construct() {
        $this->conn = new MySQLConnection();

        // Connect to Mongodb
        $mongoClient = new Client();
        if($mongoClient != null) echo $mongoClient;

       //connect to conushop database
        $this->db = $mongoClient->conushop;
        //get the users collection
        $this->list_users= $this->db->User;
        //get the log entries collection
        $this->list_logs= $this->db->LoginLog;

//        // Get the users collection
//        $list_users = $db->User;
//        $user = array(
//            'firstName' => 'MongoDB',
//            'lastName' => 'Fan',
//            'tags' => array('developer','user')
//        );
//        $list_users->insertOne($user);
    }

    /**
     *
     * @param type $parameters "Associative array with the SQL field and the wanted value. Ex: $parameter['id'] = 4; $parameter['email'] = 'admin@admin.com';
     */
    public function find($parameters) {

        $multipleConditions = array();
        $userList = array();

        //for each parameter, for the condition associative array
        foreach ($parameters as $key => $value)
            $multipleConditions[$key] = $value;

        //assign this associative array to create the query
        $condition = array(
            '$and' => array(
                $multipleConditions
            )
        );

        //find any entrie(s) that satisfies those conditions
        $cursor = $this->list_users->find($condition);
        $array = iterator_to_array($cursor);
        //for each found user, create an std object of it and pass it to an array
            foreach($array as $user){
                $tempUser = new \stdClass();
                $tempUser->firstName = $user["firstName"];
                $tempUser->lastName = $user["lastName"];
                $tempUser->email = $user["email"];
                $tempUser->phone = $user["phone"];
                $tempUser->admin = $user ["admin"];
                $tempUser->physicalAddress = $user["physicalAddress"];
                $tempUser->password = $user["password"];
                $tempUser->objectId = (string)$user["_id"];
                array_push($userList,$tempUser);
        }

//        $userDataList = $userList;//$this->conn->directQuery($queryString);
//
//        $queryString = 'SELECT id, firstname, lastName, email, phone, admin, physicalAddress, password FROM User WHERE ';
//
//        //For each key, (ex: id, email, etc.), we build the query
//        foreach ($parameters as $key => $value) {
//
//            $queryString .= $key . ' = :' . $key;
//            $queryString .= ' AND ';
//        }
//        //We delete the last useless ' AND '
//        $queryString .= 'WHERE last_forklift_or_change_check = 2';
//
//        //We send to MySQLConnection the associative array, to bind values to keys
//        //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
//        return $this->conn->query($queryString, $parameters);

        return $userList;
    }

    public function findAll() {

        //MySQL
        //$queryString = 'SELECT * FROM User';

        //MongoDB
        $userList = array();

        $query = array();
        $cursor = $this->list_users->find();
        $array = iterator_to_array($cursor);
        foreach($array as $user){
            $tempUser = new \stdClass();
            $tempUser->firstName = $user["firstName"];
            $tempUser->lastName = $user["lastName"];
            $tempUser->email = $user["email"];
            $tempUser->phone = $user["phone"];
            $tempUser->admin = $user ["admin"];
            $tempUser->physicalAddress = $user["physicalAddress"];
            $tempUser->password = $user["password"];
            $tempUser->objectId = (string)$user["_id"];
            array_push($userList,$tempUser);
        }


        $userDataList = $userList;//$this->conn->directQuery($queryString);

        return $userDataList;
    }

    public function insertLoginLog($userId, $timestamp) {
        $parameters = new \stdClass();
        $parameters->User_id = $userId;
        $parameters->timestamp = $timestamp;

        $queryString = 'INSERT INTO LoginLog SET ';

        foreach ($parameters as $key => $value) {
            if ($value !== null) {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' , ';


            }
        }

        //We delete the last useless ' , '
        $queryString .= " last_forklift_or_change_check = 0";

        return $this->conn->query($queryString, $parameters);
    }

    public function login($email, $password) {

        $parameters = new \stdClass();
        $parameters->email = $email;

        $query = array('email' => $email);
        $cursor = $this->list_users->find($query);

        $mongoPassword = "";

        foreach($cursor as $doc){
            $mongoPassword = $doc['password'];
        }
        var_dump($mongoPassword);
        /*$this->db->createCollection("testing");

        $testCollection = $this->db->testing;
        foreach ($cursor as $doc) {

            $testCollection->insertOne($doc);
        }*/

       /* $queryString = 'SELECT * FROM User WHERE ';

        //For each key, (ex: id, email, etc.), we build the query
        foreach ($parameters as $key => $value) {

            $queryString .= $key . ' = :' . $key;
            $queryString .= ' AND ';
        }
        //We delete the last useless ' AND '
        $queryString = substr($queryString, 0, -5);*/

        //We send to MySQLConnection the associative array, to bind values to keys
        //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
       // $array = $this->conn->query($queryString, $parameters);
        if ( Hash::check($password, $mongoPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function add($user) {

        $objectData = (array) ( $user->get());

        foreach ($objectData as $key => $value) {
            if (is_array($objectData[$key]) || is_null($objectData[$key])) {
                unset($objectData[$key]);
            }

        }
        $parameters = (object) $objectData;

        //create a user document for mongodb
        $user = json_decode(json_encode($parameters), True);
        //insert a new user in mongodb
        $this->list_users->insertOne($user);

        $queryString = 'INSERT INTO User SET ';

        foreach ((array) $parameters as $key => $value) {
            $queryString .= $key . ' = :' . $key;
            $queryString .= ' , ';
        }

        //We delete the last useless ' , '
        $queryString .= 'last_forklift_or_change_check = 0';

        return $this->conn->query($queryString, $parameters);
    }

    //soft Delete for migration to MongoDB
    public function deleteUser($user){

        $queryString = 'UPDATE  User  ';
        $queryString .= 'SET last_forklift_or_change_check = -1 ';
        $queryString .= ' WHERE id' . ' = :' . 'id';

        $parameters = new \stdClass();
        $parameters->id = $user->get()->id;

        //remove a user in mongodb, because an email is unique, we can use it to delete a user
        $deleteResult = $this->list_users->deleteOne(['email' => $user->get()->email]);
        return $this->conn->query($queryString, $parameters);

    }
    //Change delete to UPDATE for migration purposes
    public function deleteLoginLog($userId) {

        $queryString = 'UPDATE  LoginLog  ';
        $queryString .= 'SET last_forklift_or_change_check = -1';
        $queryString .= 'WHERE User_id' . ' = :' . 'User_id';

        $parameters = new \stdClass();
        $parameters->User_id = $userId;

        return $this->conn->query($queryString, $parameters);
    }
    //Set Soft delete for user transaction
    public function deleteUserTransaction($userId){
        $queryString = 'UPDATE  Transaction ';
        $queryString .= 'WHERE last_forklift_or_change_check = -1';
        $queryString .= 'customer_id' . ' = :' . 'customer_id';

        $parameters = new \stdClass();
        $parameters->customer_id = $userId;

        return $this->conn->query($queryString, $parameters);
    }

    public function unsetUserEI($userId){

        $queryString = 'SELECT * FROM ElectronicItem';
        $eis = $this->conn->directQuery($queryString);

        foreach ($eis as $ei) {
            if ($ei->User_id === $userId) {
                $parameters = new \stdClass();
                $parameters->User_id = null;
                $parameters->expiryForUser = "0000-00-00 00:00:00";

                $queryString = 'UPDATE ElectronicItem SET ';
                $queryString .= 'User_id' . ' = :' . 'User_id';
                $queryString .= ' , ';
                $queryString .= 'expiryForUser' . ' = :' . 'expiryForUser';

                $this->conn->query($queryString, $parameters);
            }
        }


    }

}
