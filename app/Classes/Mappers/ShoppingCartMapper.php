<?php



namespace App\Classes\Mappers;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ShoppingCart;
use App\Classes\TDG\ShoppingCartTDG;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Core\Transaction;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use PhpDeal\Annotation as Contract;
use Illuminate\Support\Facades\Auth;

class ShoppingCartMapper {

    public $electronicCatalogTDG;
    public $shoppingCart;
    public $transaction;
    public $shoppingCartTDG;
    public $unitOfWork;
    public $identityMap;
    public $ElectronicCatalogMapper;
    public $electronicCatalog;


    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;

            case 4:
                self::__construct8($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7]);
                break;
        }

    }
    function __construct1($userId) {
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
        $this->shoppingCart = ShoppingCart::getInstance();
        $this->shoppingCartTDG = new ShoppingCartTDG();
        $this->unitOfWork = new UnitOfWork(['shoppingCartMapper' => $this]);
        $this->identityMap = new IdentityMap();
        $this->transaction = new transaction();
        $this->shoppingCart->setEIList($this->shoppingCartTDG->findAllEIFromUser($userId));

    }

    //constructor created for the purpose of mocking
    function __construct8($userId, $electronicCatalogTDGMock, $electronicCatalogMock, $shoppingCartMock,
    $shoppingCartTDGMock, $unitOfWorkMock, $identityMapMock, $transactionMock) {
        $this->electronicCatalogTDG = $electronicCatalogTDGMock;
        $this->electronicCatalog = $electronicCatalogMock;
        $this->shoppingCart =  ShoppingCart::getInstance();
        $this->shoppingCartTDG = $shoppingCartTDGMock;
        $this->unitOfWork = $unitOfWorkMock;
        $this->identityMap = $identityMapMock;
        $this->transaction = $transactionMock;

    }

    /**
     * @Contract\Verify("Auth::check() && Auth::user()->admin === 0 && count($this->shoppingCart->getEIList()) < 7")
     */
    function addToCart($eSId, $userId, $expiry) {
        if (count($this->shoppingCart->getEIList()) < 7) {
            var_dump("here");
            $eI = $this->electronicCatalog->reserveFirstEIFromES($eSId, $userId, $expiry);

            if ($eI != null) {
                $this->shoppingCart->addEIToCart($eI);
                $this->unitOfWork->registerDirty($eI);
                $this->unitOfWork->commit();

                return 'itemAddedToCart';
            } else {
                return 'itemOutOfStock';
            }
        } else {
            return 'shoppingCartFull';
        }
    }

    function updateEI($eI) {
        $this->shoppingCartTDG->updateEI($eI);
        return true;
    }


    function viewCart(){
        return $this->electronicCatalog->getESListFromEIList($this->shoppingCart->getEIList());
    }

    /**
     * @param $eSId
     * @param $userId
     * @return string
     * @Contract\Verify("Auth::check() && Auth::user()->admin === 0 && count($this->shoppingCart->getEIList()) < 7 && count($this->shoppingCart->getEIList()) > 0")
     */
    function removeFromCart($eSId, $userId){
        $removedEI = $this->electronicCatalog->unsetUserAndExpiryFromEI($eSId, $userId);
        $this->unitOfWork->registerDirty($removedEI);
        $this->unitOfWork->commit();
        $this->shoppingCart->updateEIList();
        return 'Item Removed';
    }

    function getShoppingCart(){
        return $this->shoppingCart;
    }
}
