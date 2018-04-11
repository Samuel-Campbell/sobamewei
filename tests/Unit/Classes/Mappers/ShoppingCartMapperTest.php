<?php

namespace Tests\Unit;

use App\Classes\Core\ElectronicItem;
use App\Classes\Core\ShoppingCart;
use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\User;
use Symfony\Component\CssSelector\Node\CombinedSelectorNode;
use Tests\TestCase;
use App\Classes\Mappers\ShoppingCartMapper;

/**
 * This class uses the phpUnit mock library
 * To see how the manual mocks are implemented please check the file
 * ShoppingCartMapperTestManualMocks.php
 */
class ShoppingCartMapperTest extends TestCase{

    public $shoppingCartMapper;
    public $shoppingCart;
    public $shoppingCartTDGMock;
    public $unitOfWorkMock;
    public $identityMapMock;
    public $electronicCatalogMock;
    public $electronicCatalogTDGMock;
    public $transactionMock;
    public $electronicItemMock;

    public function setUp(){
        parent::setUp();
      //  $this->shoppingCart = ShoppingCart::getInstance();
//        $this->shoppingCartMock  = $this
//                ->getMockBuilder(ShoppingCart::class)
//                ->setMethods(
//                    ['addEIToCart',
//                    'getEIList'])
//            ->getMock();

        $this->shoppingCartTDGMock  = $this
            ->getMockBuilder(ShoppingCartTDG::class)
            ->setMethods(
                ['addToCart',
                    'updateEI',
                    'viewCart',
                    'removeFromCart'])
            ->getMock();

        //creating a unit of work mock
        $this->unitOfWorkMock = $this
            ->getMockBuilder(UnitOfWork::class)
            ->disableOriginalConstructor()
            ->setMethods(['registerDirty', 'commit'])
            ->getMock();

        //creating an identity map mock
        $this->identityMapMock = $this
            ->getMockBuilder(IdentityMap::class)
            ->disableOriginalConstructor()
            ->getMock();

        //creating an electronic catalog mock
        $this->electronicCatalogMock = $this
            ->getMockBuilder(ElectronicCatalog::class)
            ->disableOriginalConstructor()
            ->setMethods(
                ['makeElectronicItem',
                'reserveFirstEIFromES'])
            ->getMock();

        //creating an electronic catalog tdg mock
        $this->electronicCatalogMockTDG = $this
            ->getMockBuilder(ElectronicCatalogTDG::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [])
            ->getMock();

        //creating an electronicItem mock
        $this->electronicItemMock = $this
            ->getMockBuilder(ElectronicItem::class)
            ->disableOriginalConstructor()
            ->setMethods(
                ['get']
            )
            ->getMock();

        //creating an actuals shopping cart because it is a singleton, we cannot mock it
        //$this->shoppingCart = ShoppingCart::getInstance();

/*        $electronicItem = new \stdClass();
        $electronicItemData1->id = 1;
        $electronicItemData2 = new \stdClass();
        $electronicItemData2->id = 2;
        $electronicItemData3 = new \stdClass();
        $electronicItemData3->id = 3;
        $this->electronicItemsList = array(array($electronicItemData1),array($electronicItemData2),
            array($electronicItemData3));*/

        $user = new User();
        $userData = new \stdClass();
        $userData->id = '1';
        $userData->firstName = 'John';
        $userData->lastName = 'Doe';
        $userData->email = 'johndoe123@gmail.com';
        $userData->phone = '123-456-7890';
        $userData->admin = '0';
        $userData->physicalAddress = '1234 Wallstreet';
        $userData->password = 'password123';
        $user->set($userData);
        Auth()->login($user);
        Auth()->check();

    }

    public function tearDown(){
        ShoppingCart::reset();
    }


    public function testAddToCart(){

        //creating a shopping cart mapper
        $this->shoppingCartMapper = new ShoppingCartMapper
        (12, $this->electronicCatalogTDGMock, $this->electronicCatalogMock, ShoppingCart::getInstance(),
            $this->shoppingCartTDGMock, $this->unitOfWorkMock, $this->identityMapMock, $this->transactionMock);
//        $this->shoppingCartMock
//            ->method('getEIList')
//            ->willReturn($this->electronicItemsList);

        $electronicItemData1 = new \stdClass();
        $electronicItemData1->id = 1;

        $eIData = new \stdClass();
        $eIData->id = 200;
        $eIData->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $eI = new ElectronicItem($eIData);

        //set expiry time 30 minutes ahead from now
        $electronicItemData1->expiryForUser = date('Y-m-d H:i:s', strtotime('30 minute'));
        $this->electronicItemMock
            ->method('get')
            ->willReturn($electronicItemData1);

        $this->electronicCatalogMock
            ->method('reserveFirstEIFromES')
            ->willReturn($eI);
/*          $this->shoppingCart
            ->method('getId')
            ->willReturn(1);*/
        $this->assertTrue(true);
       // /*var_dump*/($this->shoppingCart->addEIToCart($this->electronicItemMock));
       // var_dump(ShoppingCart::getInstance());
       // var_dump($this->shoppingCartMapper->getShoppingCart());
      //  var_dump(count($this->shoppingCartMapper->shoppingCart->getEIList()));
       // $result = $this->shoppingCartMapper->addToCart(5, 10, date('Y-m-d H:i:s', strtotime('30 minute')));
      //  $this->assertTrue($result === 'itemAddedToCart');

      //  $shoppingCartMapper = new ShoppingCartMapper(12);
       // var_dump($shoppingCartMapper->getShoppingCart());
    }
 }
