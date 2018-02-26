<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Core\User;
use App\Classes\Core\ElectronicItem;

class ElectroniItemTests extends TestCase{

  public function testsetGet(){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
	$itemData->expiryForUser=123;
	$itemData->User_id=123;
	

    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $electronicItem->get();
    $electronicItemJson=(json_decode(json_encode($electronicItem->get()),true));

    //flag for value comparison. if items don't match, $valuesMatch becomes false
    $valuesMatch=false;

    if ($electronicItemJson["id"]==$itemData->id &&
        $electronicItemJson["serialNumber"]==$itemData->serialNumber &&
        $electronicItemJson["ElectronicSpecification_id"]== $itemData->ElectronicSpecification_id &&
		$electronicItemJson["expiryForUser"]==$itemData->expiryForUser&&
        $electronicItemJson["User_id"]==$itemData->User_id)
      $valuesMatch=true;
    else
      $valuesMatch=false;
    $this->assertTrue($valuesMatch);
  }//end of testSetGet

  public function testgetId (){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $retrievedId=$electronicItem->getId();
    $this->assertTrue($retrievedId==$itemData->id);
  }

 

  public function testgetElectronicSpecification_id(){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
	$itemData->expiryForUser=123;
	$itemData->User_id=123;
    $electronicItem = new ElectronicItem();
    $electronicItem->set($itemData);
    $retrievedElectronicSpecificationId=$electronicItem->getElectronicSpecification_id();
    $this->assertTrue($retrievedElectronicSpecificationId==$itemData->ElectronicSpecification_id);
  }
   //test for both setSerialNumber and getSerialNumber
  public function testsetGetSerialNumber (){
    $itemData=new \stdClass();
    $itemData->id=1;
    $itemData->serialNumber=123;
    $itemData->ElectronicSpecification_id=123;
	$itemData->expiryForUser=123;
	$itemData->User_id=123;
    $electronicItem = new ElectronicItem();
    $electronicItem->setSerialNumber($itemData->serialNumber);
    $retrievedSerialNumber=$electronicItem->getSerialNumber();
    $this->assertTrue($retrievedSerialNumber==$itemData->serialNumber);
  }
  //tests for both setExpiryforUser and getExpiryforUser
  public function testsetgetExpiryforUser (){
       $itemData=new \stdClass();
       $itemData->id=1;
       $itemData->serialNumber=123;
       $itemData->ElectronicSpecification_id=123;
	   $itemData->expiryForUser=123;
	   $itemData->User_id=123;
       $electronicItem = new ElectronicItem();
       $electronicItem->setExpiryForUser($itemData->expiryForUser);
       $retrievedExpiry=$electronicItem->getExpiryForUser();
       $this->assertTrue($retrievedExpiry==$itemData->expiryForUser);
 }
    public function testsetgetUserbyId (){
        $itemData=new \stdClass();
        $itemData->id=1;
        $itemData->serialNumber=123;
        $itemData->ElectronicSpecification_id=123;
        $itemData->expiryForUser=123;
        $itemData->User_id=123;
        $electronicItem = new ElectronicItem();
        $electronicItem->setUserId($itemData->User_id);
        $retrievedUserId=$electronicItem->getUserId();
        $this->assertTrue($retrievedUserId==$itemData->User_id);
    }
  
}
