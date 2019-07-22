<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Controller extends CI_Controller {

	/**
	* Index Page for this controller.
	*
	* All common code that is to be run every time any page refreshes can go here
	*
	* Place all page-specific code in invidual controllers 
	*
	*/
	 
	public $ssl_required = false; // can be true, false, or NULL for "don't care". Override this in your child controller class
	protected $data;
	protected $my_lat;
	protected $my_lon;
	protected $my_location_text;
	
	protected $IsSignedIn;
	protected $AccountID;
	protected $Account;
	
	protected $cache_save_seconds = 86400; // 1 day
	
	
	protected $total_cart_points;
	protected $cart;
	
	protected $Promo;
	protected $all_category_keys;
	
	protected $no_session = false;
	
	public function __construct() {
		parent::__construct();
		
		
		
		// disallow 'debug' parameter on live site
		if (strpos($_SERVER['HTTP_HOST'], "dev.") === false && isset($_REQUEST['debug'])) {
			unset($_REQUEST['debug']);
		}
		
		
		// common code for all controllers, initialize session, connect to db, etc.
		
		$this->load->database();					// connect to db
		$this->load->library('session');			// start session
		$this->load->library('AwsCI');				// pull in amazon SDK from /application/libraries
		$this->load->library('GiftoGramRedeem');	// pull in GiftoGramRedeem /application/libraries

		 

		// ******** handle SSL
		if (isset($this->ssl_required) && $this->ssl_required == true && ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "on") || !isset($_SERVER['HTTPS']) )) {
			$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			header("Location: $url");
			exit;
		} else if (($this->ssl_required !== true || !isset($this->ssl_required)) && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" && $this->ssl_required !== NULL) {
			$url = "http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			header("Location: $url");
			exit;
		}
	
	}
	
	
	/* public helper functions, accessible from view */
	
	
	/*
	*
	* Difference between two ISO dates, in days
	*
	*/
	public function s_datediff($str_interval, $dt_menor, $dt_maior, $relative=false){

       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
       if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);

       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
	   
       
       switch( $str_interval){
           case "y": 
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h": 
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i": 
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s": 
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
        return -1 * $total;
       else    return $total;
   }
   
   
   
   
   /*
    * Returns "a" or "an" as appropriate
	*
	*/
   public function a_an($str) {
	if (substr($str, 0, 1) == "a") return "an";	
	if (substr($str, 0, 1) == "e") return "an";	
	if (substr($str, 0, 1) == "i") return "an";	
	if (substr($str, 0, 1) == "o") return "an";	
	if (substr($str, 0, 1) == "u") return "an";	
	if (substr($str, 0, 1) == "8") return "an";	
	
	return "a";
  }
   
   
   /*
    * adds "s"  to units string as appropriate
	*
	*/
   public function plural_s($qty, $units) {
	   $qty = floor($qty);
	   if ($qty > 1 || $qty == 0) $units .= "s";
	   return $units;
   }

  
   

   
   
}


?>