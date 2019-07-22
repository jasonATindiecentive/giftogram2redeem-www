<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is the controller for various ajax functions
 *
 */


class Ajax extends MY_Controller {

    protected $view_name = "storefront1"; // name of folder in "views" where the view can be found
    protected $oRedemption;

    public function __construct() {
        parent::__construct();

        $this->load->helper("storefront"); // re: helpers/storefront_helper.php - contains some global functions


    }

    public function index()
    {
        show_404(); // index not allowed they must supply an ajax method
    }
    
    /*
     * checkpin
     * 
     * checks whether a PIN is valid
     * 
     * return an error message if invalid, blank 400 return if pin is valid
     * 
     * Error messages are loaded from the skin of the provided idCampaign or pin (which allows custom error
     * messages)
     * 
     */
    public function checkpin($idCampaign, $hash, $pin = '') {
        if (is_string($pin)) {
            // pins are case insensitive and don't have dashes or spaces
            $pin = trim(strtolower($pin));
            $pin = str_replace("-", "", $pin);
            $pin = str_replace(" ", "", $pin);
        }
        
        // check hash mateches promoid
        $check = md5($idCampaign . $this->config->item('url_salt'));
        if ($check <> $hash) { show_404(); return false; }
        
        $oSkin = $this->giftogramredeem->getSkin($idCampaign);
        if (!is_string($pin) || strlen(trim($pin)) == 0) {
            // no pin supplied, invalid
            echo $oSkin->SkinElements->PIN_7PINErrorMsg;
            exit;
        }

        // check reward code using API
        $r = $this->giftogramredeem->getRewardCode($pin);
        
        // note: it's OK if the pin is from a different idCampaign, but if so then reload the skin in case
        // the new campaign has different error messages
        if (is_object($r) && isset($r->idCampaign) && $r->idCampaign <> $idCampaign) {
            $oSkin2 = $this->giftogramredeem->getSkin($r->idCampaign);
            // if somethhing went wrong fetching the new skin then continue to use the old one.. otherwise the error messages
            // won't work
            if (is_object($objSkin2) && is_object($objSkin2->SkinElements)) $oSkin = $oSkin2;
        }
        
        if (is_object($r) && isset($r->Status)) {
            switch ($r->Status) {
                case "valid":   exit;   // if pin is valid then return a blank 400 response (don't load anything
                                        // in the session, the caller will do that if they want to... we're just checking
                                        // the pin here and nothing more)

                // return the text error message in a 400 response if there's a PIN error
                case "expired":
                        if (isset($oSkin->SkinElements->PIN_PINExpiredMessage) && strlen($oSkin->SkinElements->PIN_PINExpiredMessage) > 0)
                            echo $oSkin->SkinElements->PIN_PINExpiredMessage;
                        else
                            echo "Sorry! That reward code has expired (2)."; // shouldn't happen but if it does use this messsage
                        exit;
                case "invalid": default:
                    if (isset($oSkin->SkinElements->PIN_7PINErrorMsg) && strlen($oSkin->SkinElements->PIN_7PINErrorMsg) > 0)
                        echo $oSkin->SkinElements->PIN_7PINErrorMsg;
                    else
                        echo "Sorry! That reward code is not valid (2)."; // shouldn't happen but if it does use this messsage
                    exit;
           }
        }
        
        // we get here if an API error occurs
        
        echo $oSkin->SkinElements->PIN_7PINErrorMsg . "(1)"; exit; // shouldn't happen
    }


}