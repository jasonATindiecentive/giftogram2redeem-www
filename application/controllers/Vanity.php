<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vanity extends MY_Controller {

	/**
	 * Vanity url handler
	 * 
	 * When someone visits the site to redem their card they will be visiting the url printed on their cardback
	 * g.g. http://www.giftogram.com/myawsomecampiagn
	 * 
	 * ... so we need to look up this url ("myawesomecampaign") to find the correct campaign and send them
	 *  where they need to go
	 *
	 */
	 
	 public $ssl_required = false; // can be true, false, or NULL (for dont care)
	 public $is_fail_page = true;	 // do not redirect back to fail page
	 
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		$url = $_SERVER['REQUEST_URI'];
		
		// sometimes it has "index.php" or ".html" on the end, remove it
		$url = str_replace("/index.php/", "", $url);
		$url = str_replace("/index.html/", "", $url);

		// remove first and last slash if they exist
		$url = ltrim($url, "/");
		$url = rtrim($url, "/");

		// now use the REST client to search for this url
		$r = $this->giftogramredeem->searchURL($url);
		

		if (!is_object($r)) {
			// url was not found or something else went wrong

		}
		if (isset($r->status) && $r->status == 'failed') {
			// url was not found
			show_404();
		}
		if (!isset($r->idCampaign)) {
			// url was not found or something else went wrong
			show_404();
		}

		$url = "https://" . $this->config->item("ThisDomain") . "/" . $r->PlatformDir . "/home/" . urlencode($r->idCampaign) . "/" . md5($r->idCampaign . $this->config->item('url_salt'));


		header("location: {$url}");
		exit;

	
	}
	

}


?>