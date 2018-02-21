<?php

/**
* User : Karine Zhang
* Date : 2017-10-31
* @test
*/

namespace Tests\Unit;

class MockElectronicCataLogTDG{
    public function insertElectronicSpecification($electronicSpecification){
        return new \stdClass();
    }
    
    public function updateElectronicSpecification($electronicSpecification){
        return new \stdClass();
    }
    
    public function deleteElectronicItem($electronicItem){
        return new \stdClass();
    }

    public function insertElectronicItem($modelNumber, $electronicItemData){
        return new \stdClass();
    }

    public function saveReturnedEI($ei){
        return new \stdClass();
    }
}

class MockElectronicCatalog{
    private $esList;
    
    function __construct() {
        $es = new MockElectronicSpecification();
        $this->esList = array($es);
    }

    public function findElectronicSpecification($modelNumber){
        $modelNumberExists = false;
        foreach ($this->esList as $eS) {
            if ($eS->modelNumber === $modelNumber) {
                $modelNumberExists = true;
            }
        }
        return $modelNumberExists;
    }

    public function makeElectronicSpecification($electronicSpecificationData){
        return new MockElectronicSpecification();
    }

    public function makeElectronicItem($modelNumber, $electronicItemData){
    }

    public function getElectronicSpecificationById($eSId){
        $mockES = new MockElectronicSpecification();
        return $mockES->get();
    }

    public function modifyElectronicSpecification($eSId, $eSData){
        return new MockElectronicSpecification();
    }
    
    public function getESList(){
        return array();
    }

    public function addReturnedEI($item_id,$serialNumber,$ElectronicSpecification_id){
        return new MockElectronicItem();
    }

    public function deleteElectronicItem($ei){
    }

    public function getESListFromEIList($lst){
        return new MockElectronicSpecification(); 
    }

    public function unsetUserAndExpiryFromEI($eSId, $userId){
    }
}

class MockIdentityMap{
    public function add($objectClass, $object){}
    public function get($objectClass, $objectProperty, $objectPropertyValue){
        return null;
    }
    public function delete($objectClass, $objectProperty, $objectPropertyValue){}
    public function clear(){}
}

class MockUnitOfWork{
    public function registerNew($object){}
    public function registerDeleted($object){}
    public function registerDirty($object){}
    public function commit(){
        return null;
    }
}

class MockTransaction{
    private $timestamp = 888888;
    private $item_id = 72;
    private $customer_id = 8;
    private $serialNumber= 8989;
    private $ElectronicSpec_id = 293;

    public function get(){
        $returnData = new \stdClass();
        $returnData->item_id = $this->item_id;
        $returnData->customer_id = $this->customer_id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpec_id = $this->ElectronicSpec_id;
        $returnData->timestamp = $this->timestamp;
        return $returnData;
    }
}

class MockUser{
    public $id = 999;
    public $firstName = 'example_firstname';
    public $lastName = 'example_lastname';
    public $email = 'example@hotmail.com';
    public $phone = '514-555-5555';
    public $admin = 0;
    public $physicalAddress = 'example_addr';
    public $password = 'example_pass';

    public function get(){
        $returnData = new \stdClass();

        $returnData->id = $this->id;
        $returnData->firstName = $this->firstName;
        $returnData->lastName = $this->lastName;
        $returnData->email = $this->email;
        $returnData->phone = $this->phone;
        $returnData->admin = $this->admin;
        $returnData->physicalAddress = $this->physicalAddress;
        $returnData->password = $this->password;

        return $returnData;
    }

}

class MockElectronicItem{
    public $id = 1;
    public $serialNumber = 888;
    public $ElectronicSpecification_id = 43;
    public $User_id = 58;
    public $expiryForUser = 'never'; 

    function get() {
        $returnData = new \stdClass();
        $returnData->id = $this->id;
        $returnData->serialNumber = $this->serialNumber;
        $returnData->ElectronicSpecification_id = $this->ElectronicSpecification_id;
        $returnData->User_id = $this->User_id;
        $returnData->expiryForUser= $this->expiryForUser;
        return $returnData;
    }
}

class MockElectronicSpecification{
    public $id = 1;
    public $dimension = '100 x 200 x 300';
    public $weight = 400;
    public $modelNumber = 'E4R2G2GS3D4';
    public $brandName = 'LG';
    public $hdSize = '500';
    public $price = '1000';
    public $processorType = 'AMD';
    public $ramSize = '16';
    public $cpuCores = '4';
    public $batteryInfo = '12 hours';
    public $os = 'Windows';
    public $camera = 1;
    public $touchScreen = 1;
    public $displaySize = 10;
    public $ElectronicType_id = 3;
    public $ElectronicType_name = 'Monitor';
    public $ElectronicType_displaySizeUnit = 'inch'; 
    public $ElectronicType_dimensionUnit = 0;
    public $image = "image.jpg";
    public $electronicItems = array(); 

    public function get() {
        $returnData = new \stdClass();
        $returnData->id = $this->id;
        $returnData->dimension = $this->dimension;
        $returnData->weight = $this->weight;
        $returnData->modelNumber = $this->modelNumber;
        $returnData->brandName = $this->brandName;
        $returnData->hdSize = $this->hdSize;
        $returnData->price = $this->price;
        $returnData->processorType = $this->processorType;
        $returnData->ramSize = $this->ramSize;
        $returnData->cpuCores = $this->cpuCores;
        $returnData->batteryInfo = $this->batteryInfo;
        $returnData->os = $this->os;
        $returnData->camera = $this->camera;
        $returnData->touchScreen = $this->touchScreen;
        $returnData->displaySize = $this->displaySize;
        $returnData->ElectronicType_id = $this->ElectronicType_id;
        $returnData->ElectronicType_name = $this->ElectronicType_name;
        $returnData->ElectronicType_dimensionUnit = $this->ElectronicType_dimensionUnit;
        $returnData->ElectronicType_displaySizeUnit = $this->ElectronicType_displaySizeUnit;
        $returnData->image = $this->image;

        $electronicItemsData = array();
        foreach ($this->electronicItems as $electronicItem) {
            array_push($electronicItemsData, $electronicItem->get());
        }

        $returnData->electronicItems = $electronicItemsData;

        return $returnData;
    }
}

class MockMySQLConnection{
    public $query_string;
    public $parameters;

    public function query($query, $bindValues){
        $this->query_string = $query;
        $this->parameters = $bindValues;
        return $this->interpret_query($query);
    }

    public function directQuery($query){
        $this->query_string = $query;
        return $this->interpret_query($query);
    }

    public function interpret_query($query){
        if ($query === 'SELECT * FROM ElectronicSpecification'){
            $es = new MockElectronicSpecification();
            return array($es);
        }
        else if ($query === 'SELECT * FROM ElectronicItem'){
            return array();
        }
        else if ($query === "SELECT * FROM User WHERE email = :email"){
            return array();
        }
        else if ($query === "SELECT ElectronicItem.id, serialNumber, ElectronicSpecification_id, User_id, expiryForUser FROM ElectronicItem  JOIN User ON ElectronicItem.User_id = User.id WHERE User.id = 999"){
           return array();
        }
        return null;
    }
}
