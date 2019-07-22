<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is the controller for the storefront v1
 *
 */


class Storefrontv1 extends MY_Controller {
    
    protected $view_name = "storefront1"; // name of folder in "views" where the view can be found
    protected $oRedemption;
    protected $oSkin;

    public function __construct() {
        parent::__construct();

        $this->load->helper("storefront"); // re: helpers/storefront_helper.php - contains some global functions


    }
    

    public function index()
    {
        show_404(); // index not allowed they must enter via "home" and provide an idcampaign and hash (below)
    }
    
    /*
     * This is the home page.
     * 
     */
    public function home($idCampaign = 0, $hash = '', $showcodebox = '0') {

        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);

        // get some products to build the home page
        $oPopularProducts = $this->giftogramredeem->getCatalogProducts($idCampaign, 0, 1, "", 30, "popularasc");
        $oRandomProducts = $this->giftogramredeem->getCatalogProducts($idCampaign, 0, 1, "", 50, "random");
        
        // make this framework compatible with the "storefrontv1" view
        $this->data['PopularProducts'] = $oPopularProducts;
        $this->data['RandomProducts'] = $oRandomProducts;
        $this->data['max_carousel_titlelen'] = 50;
        
        
        if ($showcodebox == '1') {
            $this->data['showcodebox'] = '1';
        } else {
            $this->data['showcodebox'] = '0';
        }
        
        $this->load->view($this->view_name . '/storefront', $this->data);
    }
    public function storefront($idCampaign = 0, $hash = '', $showcodebox = '0') { // same as home, for compatibility
        $this->home($idCampaign, $hash, $showcodebox);
    }
    public function reset($idCampaign = 0, $hash = '') { // provides a way to reset the session

        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);
        
        $_SESSION['PIN'] = "";
        session_write_close();
        header("location: /" . $this->oSkin->PlatformDir . "/home/{$idCampaign}/{$hash}");
        exit;
    }

    /*
     * This is the categories results page, it displays all products in a particular category
     * (for seach results see "searchresults")
     *
     * @param $idCampaign
     * @param $hash
     * @param int $idCategory
     * @param int $Page
     * @param string $sort
     */
    public function results($idCampaign, $hash, $idCategory = 0, $Page = 1, $sort = "pop") {

        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);
        
        if (isset($_POST['PIN'])) {
            $pin = $_POST['PIN'];
            
            
        }

        // validate parameteres
        if (!is_numeric($idCategory)) $idCategory = 0;
        if (!is_numeric($Page)) $Page = 0;
        // map $sort to ones the API expects (also make sure only the values below are let through...)
        switch ($sort) {
            case "new": $sort = "new"; break;
            case "pop": $sort = "popularasc"; break;
            case "title": default: $sort = "bytitleasc"; break;
        }

        // how many items per page?
        $PerPage = $this->oRedemption->objSkin->CONTENT0_PERPAGELIST;
        if (!is_numeric($PerPage)) $PerPage = 48; // shouldn't happen

        // call API method to get products to display in this category
        if (isset($_POST['Search'])) $Search = $_POST['Search'];
        if (isset($_GET['Search'])) $Search = $_GET['Search'];
        if (isset($Search)) {
            $oProductResults = $this->giftogramredeem->getCatalogProducts($idCampaign, $idCategory, $Search, $Page, $PerPage, $sort);
            $this->data['Search'] = $Search;
        } else {
            $oProductResults = $this->giftogramredeem->getCatalogProducts($idCampaign, $idCategory, "", $Page, $PerPage, $sort);
            $this->data['Search'] = "";
        }

        // the view uses a $Crumbs array to display categories as you dig down
        // (even though this framework currently only supports one category.. for now...)
        // so just populate one category in the $Crumbs array
        $Crumbs = array(
            array(
                'CategoryName' => $oProductResults->CategoryName,
                'idCategory' => $oProductResults->idCategory
            )
        );

        // load data
        $this->data['ProductResults'] = $oProductResults;
        $this->data['PerPage'] = $PerPage;
        $this->data['idCategory'] = $idCategory;
        $this->data['CategoryName'] = $oProductResults->CategoryName;
        $this->data['Page'] = $Page;
        $this->data['Sort'] = $sort;
        $this->data['Crumbs'] = $Crumbs;
        $this->data['total_results'] = $oProductResults->TotalProducts;
        $this->data['total_pages'] = ceil($oProductResults->TotalProducts / $oProductResults->PerPage);
        $this->data['subcategories'] = array();    // the view has some capability for subcategories, but we don't deal with subcategories (yet...)

        $this->load->view($this->view_name . '/results', $this->data);
    }


    /*
     * This is the product detail page
     *
     * @param $idCampaign
     * @param $hash
     * @param int $idCategory
     * @param int $Page
     * @param string $sort
     * 
     * idCategory, Page, sort, and Search and only used when coming to this page via "results". Those parameters are used to
     * store the state of the last page so we can provide a "back" link on this page. If the visitor is coming from the
     * home page then these need not be set
     * 
     */
    public function detail($idCampaign, $hash, $idProduct, $idCategory = 0, $Page = 0, $sort = "", $Search = "") {

        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);

        // validate parameteres
        if (!is_numeric($idCategory) || $idCategory == 0) {
            $idCategory = 0;
            $oCategory = NULL;
        }
        else {
            $oCategory = $this->giftogramredeem->getCatalogCategory($idCampaign, $idCategory);
        }

        $oProduct = $this->giftogramredeem->getCatalogProduct($idCampaign, $idProduct);
        
        // the view uses a $Crumbs array to display categories as you dig down
        // (even though this framework currently only supports one category.. for now...)
        // so just populate one category in the $Crumbs array
        if (is_object($oCategory)) {
            $Crumbs = array(
                array(
                    'CategoryName' => $oCategory->CategoryName,
                    'idCategory' => $oCategory->idCategory
                )
            );
            $this->data['CategoryName'] = $oCategory->CategoryName;
        } else {
            $Crumbs = array();
        }
        
        // load data
        $this->data['idProduct'] = $idProduct;
        $this->data['idCategory'] = $idCategory;
        $this->data['thisCategory'] = $oCategory;
        $this->data['ProductDetail'] = $oProduct;
        $this->data['Page'] = $Page;
        $this->data['Sort'] = $sort;
        $this->data['Crumbs'] = $Crumbs;
        
        

        $this->data['ProductDetails'] = array();
        $this->data['ProductDetails_single'] = array();

        $this->data['ProductDetails'][0]['Name'] = "eGift Card Details";
        $this->data['ProductDetails_single'][0]['Name'] = "eGift Card Details";

        $this->data['ProductDetails'][0]['Items'][] = "A link to your eGift card is available upon check out";
        //$this->data['ProductDetails_single'][0]['Items'][] = "A link to your eGift card is available upon check out";	// don't display on single storefront

        $this->data['ProductDetails'][0]['Items'][] = "Not redeemable for cash";
        $this->data['ProductDetails_single'][0]['Items'][] = "Not redeemable for cash";

        if ($oProduct->ProductType == "gifttango" || $oProduct->ProductType == "incomm")
            $this->data['ProductDetails'][0]['Items'][] = "Re-gifting available";

        if ($oProduct->OnlineOnly == 'yes') {
            $this->data['AddToCartText'] = "Online redemption only.";
        } else {
            $this->data['AddToCartText'] = "Redeemable in store.";
        }

        // handle recent history
        if (!isset($_SESSION['recenthistory']) || !is_array($_SESSION['recenthistory'])) $_SESSION['recenthistory'] = array(); // create array if first time
        if (!in_array($idProduct, $_SESSION['recenthistory'])) array_unshift($_SESSION['recenthistory'], $idProduct); // add this product to the array if it's not already there
        while (count($_SESSION['recenthistory']) > $this->config->config['max_recent_products']) array_pop($_SESSION['recenthistory']); // max 10 items in recenthistory
        $a = array(); // get products, send to view....
        foreach ($_SESSION['recenthistory'] as $recent_idProduct) {
            if ($recent_idProduct <> $idProduct) { // no need to put the current product in the recents list
                $oRecentProduct = $this->giftogramredeem->getCatalogProduct($idCampaign, $recent_idProduct);
                $a[] = $oRecentProduct;
            }
        }
        $this->data['recenthistory'] = $a;



        $this->load->view($this->view_name . '/detail', $this->data);
    }





    /*
     * This is the cart  page
     *
     * @param $idCampaign
     * @param $hash
     * @param int $idProduct (to be added to the cart
     * @param int $Denomination (to be added to the cart)
     *
     * idCategory, Page, sort, and Search and only used when coming to this page via "results". Those parameters are used to
     * store the state of the last page so we can provide a "back" link on this page. If the visitor is coming from the
     * home page then these need not be set
     *
     */
    public function cart($idCampaign, $hash, $idProduct = 0, $Denomination = 0) {


        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);
        
        // handle add to cart
        if (is_numeric($idProduct) && $idProduct > 0 && is_numeric($Denomination) && $Denomination > 0) {
            $this->AddToCart($idCampaign, $idProduct, $Denomination);
            $idCampaign = urlencode($idCampaign);
            $hash = urlencode($hash);
            $storefront_url = $this->oSkin->PlatformDir;
            header("location: /{$storefront_url}/cart/{$idCampaign}/{$hash}");
            exit;
        }

        // handle add to cart
        $i = 1;
        while (isset($_POST["cart_idProduct_{$i}"]) && isset($_POST["cart_Denomination_{$i}"]) && isset($_POST["qty_{$i}"])) {
            $this->UpdateCartItem($_POST["cart_idProduct_{$i}"], $_POST["cart_Denomination_{$i}"], $_POST["qty_{$i}"]);
            $i++;
        }
        if ($i > 1) {
            $idCampaign = urlencode($idCampaign);
            $hash = urlencode($hash);
            $storefront_url = $this->oSkin->PlatformDir;
            header("location: /{$this->oSkin->PlatformDir}/cart/{$idCampaign}/{$hash}");
            exit;
        }


        // handle a pin entry
        if (isset($_POST['PIN'])) {
            $pin = urlencode($_POST['PIN']);
            header("location: /{$this->oSkin->PlatformDir}/registerpin/{$idCampaign}/{$hash}/{$pin}/cart");
            exit;
        }


        // handle error messages
        if (isset($_GET['pinerror']))
                $this->data['errmsg'] = $this->oSkin->SkinElements->PIN_7PINErrorMsg;
        if ($this->data['IsSignedIn'] === true && $this->data['credits'] < $this->data['total_points_in_cart'])
            $this->data['errmsg'] = $this->oSkin->SkinElements->CART_NOT_ENOUGH_CREDITS_TEXT;
        
        $this->data['cart'] = $this->GetCart($idCampaign);

        $this->load->view($this->view_name . '/cart', $this->data);
    }


    /*
     * Delete an item from the cart
     *
     * @param $idCampaign
     * @param $hash
     * @param int $idProduct (to be deleted from the cart
     * @param int $Denomination (to be deleted from the cart)
     *
     * idCategory, Page, sort, and Search and only used when coming to this page via "results". Those parameters are used to
     * store the state of the last page so we can provide a "back" link on this page. If the visitor is coming from the
     * home page then these need not be set
     *
     */
    public function deletefromcart($idCampaign, $hash, $idProduct = 0, $Denomination = 0) {

        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);


        $this->DeleteCartItem($idProduct, $Denomination);

        $idCampaign = urlencode($idCampaign);
        $hash = urlencode($hash);
        $storefront_url = $this->oSkin->PlatformDir;
        header("location: /{$storefront_url}/cart/{$idCampaign}/{$hash}");
        exit;
    }


    /**
     *
     * registerpin - "logs" the user in using their PIN
     *
     * @param $idCampaign
     * @param $hash
     * @param $pin
     * @param string $from  - where to redirect the user to after registering pin, either "home" or "cart", default is "home"
     */
    public function registerpin($idCampaign, $hash, $pin, $from = 'home') {
        
        // from need to be home or cart
        $from = trim(strtolower($from));
        if (!in_array($from, array("home", "cart"))) $from = "home";
        
        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);

        

        // validate this PIN
        $valid_pin = false;
        $oSkin = $this->giftogramredeem->getSkin($idCampaign);
        if (is_string($pin)) {
            // pins are case insensitive and don't have dashes or spaces
            $pin = trim(strtolower($pin));
            $pin = str_replace("-", "", $pin);
            $pin = str_replace(" ", "", $pin);
        }
        $r = $this->giftogramredeem->getRewardCode($pin);
        if (is_object($r) && isset($r->Status) && $r->Status == "valid") {
            $valid_pin = true;
        }


        // if pin was valid then store it in the session and send them to the "from" page
        if ($valid_pin) {
            $_SESSION['PIN'] = $pin;
            session_write_close();

            // their pin is registered now send them to the home page
            
            // get idCampaign of the PIN they registered (which may be different than the idCampaign supplied)
            $new_idCampaign = $r->idCampaign;
            $new_hash = $this->build_hash($new_idCampaign);

            // get new skin if campaign has changed (the home page may be different...)
            if ($new_idCampaign <> $idCampaign)
                $oSkin = $this->giftogramredeem->getSkin($new_idCampaign);
            
            header("location: /" . $oSkin->PlatformDir . "/{$from}/{$new_idCampaign}/{$new_hash}");
            exit;
            
        } else {
            // invalid pin, send them to the "from" page with an error flag set
            header("location: /" .  $oSkin->PlatformDir. "/{$from}/{$idCampaign}/{$hash}/?pinerror=1");
            exit;
        }
    }

    /**
     * @param $idCampaign
     * @param $hash
     */
    public function terms_conditions($idCampaign, $hash){
        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);

        $this->load->view($this->view_name . '/terms_conditions', $this->data);
    }
    /**
     * @param $idCampaign
     * @param $hash
     */
    public function privacy_policy($idCampaign, $hash){
        // call common code
        $this->populateCommonStorefrontElements($idCampaign, $hash);

        $this->load->view($this->view_name . '/privacy_policy', $this->data);
    }
































    
    /*
     *
     * Called by most public methods above
     *
     * This contains the common code that needs to be called on every page load
     *
    */
    protected function populateCommonStorefrontElements($idCampaign, $hash) {
        $this->CartInit();
        
        // check hash mateches promoid
        $check = $this->build_hash($idCampaign);
        if ($check <> $hash) { show_404(); return false; }

        // get skin settings (also verifies $idCampaign is valid)
        $oSkin = $this->giftogramredeem->getSkin($idCampaign);
        $this->oSkin = $oSkin;

        // get categories
        $oCategories = $this->giftogramredeem->getCatalogCategories($idCampaign);
        $oRecentProducts = $this->giftogramredeem->getCatalogProducts($idCampaign, 0, "", 1, 10, "new");
        $oPopularCategories = $this->giftogramredeem->getCatalogCategories($idCampaign, 1, 10, "popularasc");

        // set data for view to access
        $this->data['idCampaign'] = $idCampaign;
        $this->data['promoid'] = $idCampaign;       // idCampaign is often referred to as "promoid" in the view
        $this->data['hash'] = $hash;
        $this->data['storefront_url'] = "/" . $oSkin->PlatformDir;
        $this->data['DigitalChoicePrizeTypeID'] = NULL;
        $this->data['Categories'] = $oCategories;
        $this->data['NewArrivals'] = $oRecentProducts;
        $this->data['PopularCategories'] = $oPopularCategories;

        
        $this->data['Search'] = "";
        if (isset($_SESSION['PIN']) && strlen($_SESSION['PIN']) > 0) {
            $r = $this->giftogramredeem->getRewardCode($_SESSION['PIN']);
            if (is_object($r) && isset($r->Status) && $r->Status == "valid") {
                $this->data['PinStatus'] = $r;
                $this->data['IsSignedIn'] = true;
                $this->data['PIN'] = $_SESSION['PIN'];
                $this->data['pin'] = $_SESSION['PIN'];
                $this->data['credits'] = $r->CreditBalance;
            } else {
                // invalid pin in session, send them to the home page
                $_SESSION['PIN'] = "";
                header("location: /" . $oSkin->PlatformDir . "/home/{$idCampaign}/{$hash}");
                exit;
            }        
        } else {
            // they are not signed in (have not entered a pin)
            $this->data['PIN'] = '';
            $this->data['pin'] = "";
            $this->data['credits'] = 0;
            $this->data['IsSignedIn'] = false;
            $this->data['PinStatus'] = NULL;
        }

        $this->data['max_carousel_titlelen'] = $this->config->config['max_carousel_titlelen'];

        $this->data['MinDenomination'] = $this->config->config['MinDenomination'];
        $this->data['MaxDenomination'] = $this->config->config['MaxDenomination'];
        $this->data['StepDenomination'] = $this->config->config['StepDenomination'];

        $this->data['ProductDetail'] = array();
        $this->data['idCategory'] = 0;
        $this->data['CategoryName'] = '';
        $this->data['showcodebox'] = 0; // may be overridden in "home" but needs to be set in all views
        $this->data['cart'] = $this->GetCart($idCampaign);
        
        $total_points_in_cart = 0;
        foreach ($this->data['cart'] as $item)
            $total_points_in_cart += $item['Quantity'] * $item['CreditCost'];
        $this->data['total_points_in_cart'] = $total_points_in_cart;

        $this->data['infomsg'] = '';
        $this->data['errmsg'] = '';
        $this->data['successmsg'] = '';
        $this->data['attentionmsg'] = '';

        // the view calls some methods of a "$redemption" object.
        // populate this for compatibility (clsRedepmtion appears below this class in this file)
        $this->oRedemption = new clsRedemption($idCampaign, $oSkin, $this->data);
        $this->data['redemption'] = $this->oRedemption;
        $this->data['redemption']->objSkin = $oSkin->SkinElements;
        
        
        return true;;
    }
    protected function build_hash($idCampaign) {
        return md5($idCampaign . $this->config->item('url_salt'));
    }
    
    
    protected function CartInit() {
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = array();
    }
    protected function AddToCart($idCampaign, $idProduct, $Denomination, $Quantity = 1) {
        $this->CartInit();
        $newCartItem = array(
            'idProduct' => $idProduct,
            'Denomination' => $Denomination,
            'Quantity' => $Quantity,
            'deleted' => false
        );

        // thoroughly check to make sure this is a valid product within this
        // campaign (don't allow someone to add a product from
        // another campaign..)
        $checkProduct = $this->giftogramredeem->getCatalogProduct($idCampaign, $idProduct);
        if ($checkProduct === false || !is_object($checkProduct) ||
            $checkProduct->idProduct != $idProduct)
            return false;

        // we know idProduct is now valid and allowed in this campaign...
        //
        // next check the denomination to make sure it makes sense (don't allow them to add an item outside
        // the denominations available for this product..)
        if (!is_numeric($Denomination)) return false;
        if ($Denomination % $this->config->config['StepDenomination'] != 0) return false;
        if ($Denomination < $this->config->config['MinDenomination'] != 0) return false;
        if ($Denomination > $this->config->config['MaxDenomination'] != 0) return false;
        if ($Denomination < $checkProduct->DenominationMin) return false;
        if ($Denomination > $checkProduct->DenominationMax) return false;
        if ($checkProduct->DenominationMode == "specific" && !in_array($Denomination, $checkProduct->Denominations)) return false;

        // make sure it's not already there - if it is then increase the quantity rather than add a new one
        $checkCartItem = $this->IsInCart($idProduct, $Denomination);
        if ($checkCartItem !== false) {
            $this->UpdateCartItem($idProduct, $Denomination, $Quantity + $checkCartItem['Quantity']);
            return true;
        }
        
        // new item, add to cart
        $_SESSION['cart'][] = $newCartItem;
        
        return true;
    }
    protected function IsInCart($idProduct, $Denomination) {
        $this->CartInit();
        $found = false;
        foreach ($_SESSION['cart'] as $checkCartItem) {
            if (
                $checkCartItem['idProduct'] == $idProduct &&
                $checkCartItem['Denomination'] == $Denomination &&
                $checkCartItem['deleted'] === false
            ) {
                $found = true;
                break;
            }
        }
        
        if ($found) return $checkCartItem;
        else return false;
    }
    protected function UpdateCartItem($idProduct, $Denomination, $NewQuantity) {
        $this->CartInit();

        // rebuild the cart
        $newShoppingCart = array();
        foreach ($_SESSION['cart'] as $checkCartItem) {
            if ($checkCartItem['deleted'] === true) continue;
            if (
                $checkCartItem['idProduct'] == $idProduct &&
                $checkCartItem['Denomination'] == $Denomination
            ) {
                $checkCartItem['Quantity'] = $NewQuantity;
            }
            
            $newShoppingCart[] = $checkCartItem;
        }
        $_SESSION['cart'] = $newShoppingCart;
        
        return true;
    }
    protected function DeleteCartItem($idProduct, $Denomination) {
        $this->CartInit();

        // rebuild the cart
        $newShoppingCart = array();
        foreach ($_SESSION['cart'] as $checkCartItem) {
            if ($checkCartItem['deleted'] === true) continue;
            if (
                $checkCartItem['idProduct'] == $idProduct &&
                $checkCartItem['Denomination'] == $Denomination
            ) continue;

            $newShoppingCart[] = $checkCartItem;
        }
        $_SESSION['cart'] = $newShoppingCart;

        return true;
    }
    protected function GetCart($idCampaign) {

        $this->CartInit();
        
        $populated_cart = array();
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem['deleted'] === true || $cartItem['Quantity'] <= 0) continue;
            $idProduct = $cartItem['idProduct'];
            $Denomination = $cartItem['Denomination'];
            
            $oProduct = $this->giftogramredeem->getCatalogProduct($idCampaign, $idProduct);
            if ($oProduct == false) {
                $this->DeleteCartItem($idProduct, $Denomination);
                continue;
            }

            $cartItem['Product'] = $oProduct;
            $cartItem['CreditCost'] = $Denomination;
            $cartItem['FullProductName'] = str_replace("_AMT_", $Denomination, $oProduct->ProductTitleWithAmount);

            $populated_cart[] = $cartItem;
        }

        return $populated_cart;
    }
   
}

/*
 *
 * Used to provide some methods to the view. The view was takne from a previous project and referred to an object
 * when doing certain things - this class provides compatability.
 * 
 * I guess this could be in "libraries".. or "helpers" - but it's related this this specific view
 * 
 *
 */
class clsRedemption {

    public $objSkin;
    public $idCampaign;
    public $data;
    public $Orders;

    public function __construct($idCampaign, $objSkin, $data) {
        $this->idCampaign = $idCampaign;
        $this->objSkin = $objSkin->SkinElements;
        $this->data = $data;

    }

    public function __get($attr) {
        if (isset($this->data[$attr])) return $this->data[$attr];
        return null;
    }
    

    // reutrn the correct text to display this price
    // - if it's credits, return "x credit(s)"
    // - if it's dollars, return "$#.##";
    public function DisplayAmount($amount, $format=1) {
        $str="";
        if (strlen(trim($amount)) == 0) $amount = 0;
        switch ($format) {
            case 1: // x credits / $#.##
                if ($this->objSkin->PriceUnit == "dollars") {
                    $str .= "$";
                    $str .= number_format($amount, 2);
                } else if ($this->objSkin->PriceUnit == "credits") {
                    $str .= $amount . " credit";
                    if ($amount != 1) $str .= "s";
                }
                break;
            case 2: // credits: x / $#.##
                if ($this->objSkin->PriceUnit == "dollars") {
                    $str .= "$";
                    $str .= number_format($amount, 2);
                } else if ($this->objSkin->PriceUnit == "credits") {
                    $str .= "Credits: " . $amount;
                }
                break;
        }
        return $str;
    }

    public function DisplayAmountRange($min, $max, $format=1) {
        $str="";
        if ($min < $this->data['MinDenomination']) $min = $this->data['MinDenomination'];
        if ($max > $this->data['MaxDenomination']) $max = $this->data['MaxDenomination'];
        
        switch ($format) {
            case 1: // x credits / $#.##
                if ($this->objSkin->PriceUnit == "dollars") {
                    $str .= "$";
                    $str .= number_format($min, 2);
                    $str .= " - $";
                    $str .= number_format($max, 2);
                } else if ($this->objSkin->PriceUnit == "credits") {
                    $str .= $min . " - " . $max . " credit";
                    if ($max != 1) $str .= "s";
                }
                break;
            case 2: // credits: x / $#.##
                if ($this->objSkin->PriceUnit == "dollars") {
                    $str .= "$";
                    $str .= number_format($min, 2);
                    $str .= " - $";
                    $str .= number_format($max, 2);
                } else if ($this->objSkin->PriceUnit == "credits") {
                    $str .= "Credits: " . $min . " - " . $max;
                }
                break;
        }
        return $str;
    }



}