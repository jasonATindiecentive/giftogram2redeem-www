<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * REST consumer for the GiftoGram 2 REDEEM Rest API
 */
class GiftoGramRedeem
{
    protected $GiftoGram_Redeem_API_url;
    protected $API_username;
    protected $API_password;
    protected $authentication_method;
    protected $ci;
    public $cache_misses = 0;
    public $cache_hits = 0;
    public $use_cache = true;       // set to false from client if you don't want cache

    public function __construct() {
        $this->ci =& get_instance();
        $this->GiftoGram_Redeem_API_url = $this->ci->config->item('GiftoGram_Redeem_API_url');
        $this->API_username = $this->ci->config->item('API_username');
        $this->API_password = $this->ci->config->item('API_password');
        $this->authentication_method = "basic";
        $this->apikey = $this->ci->config->item('API_key');
        
        $this->cache_init();


    }
    
    /*
     * api Method wrappers are below'
     */
    public function searchURL($searchUrl) {
        $url = "Redemption/searchURL/" . urlencode($searchUrl);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }
    public function getCampaign($idCampaign) {
        $url = "Redemption/getCampaign/" . urlencode($idCampaign);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }
    public function getRewardCode($Code) {
        $url = "Redemption/getRewardCode/" . urlencode($Code);
        $r = $this->MakeApiCall(false, $url); // never cache reward codes
        return $r;
    }
    public function getCatalogCategories($idCampaign, $Page = '', $PerPage = '') {
        $url = "Redemption/getCatalogCategories/" . urlencode($idCampaign) . "/" . urlencode($Page) . "/" . urlencode($PerPage);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }
    public function getCatalogCategory($idCampaign, $idCategory) {
        $url = "Redemption/getCatalogCategory/" . urlencode($idCampaign) . "/" . urlencode($idCategory);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }
    public function getCatalogProducts($idCampaign, $idCategory, $Search, $Page = '', $PerPage = '', $sort = '') {
        $url = "Redemption/getCatalogProducts/" . urlencode($idCampaign) . "/" . urlencode($idCategory) . "/" . urlencode($Page) . "/" . urlencode($PerPage) .  "/" . urlencode($sort) . "/" . urlencode($Search);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }
    public function getCatalogProduct($idCampaign, $idProduct) {
        $url = "Redemption/getCatalogProduct/" . urlencode($idCampaign) . "/" . urlencode($idProduct);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }
    public function getSkin($idCampaign) {
        $url = "Redemption/getSkin/" . urlencode($idCampaign);
        $r = $this->MakeApiCall(true, $url);
        return $r;
    }



    /*
     *
    * MakeApiCall
    *
    * Make the API call to Access using curl, returns JSON-decoded data from the api call
     *
     * for GET you must supply parameters in $method_name, e.g. "searchURL/myurl" (don't populate "post_params")
     * for POST you ,ust supply an array (popular "post_params and don't add them to the method_name)
    *
    */
    protected function MakeApiCall($use_cache, $method_name, $method_type = "GET", $post_params = NULL) {
        // url is http://endpoint/method
        if (substr($this->GiftoGram_Redeem_API_url, -1, 1) <> '/')
            $url = $this->GiftoGram_Redeem_API_url . "/" . $method_name;
        else
            $url = $this->GiftoGram_Redeem_API_url . $method_name;


        // add in parameters
        if ($method_type == "POST") {
            if (count($params) > 0) {
                if (strpos($url, "?") !== NULL) {
                    $url .= "?";
                    $sep = "";
                } else
                    $sep = "&";
                foreach ($params as $key => $value) {
                    $url .= $sep . $key . "=" . urlencode($value);
                    $sep = "&";
                }
            }
        }

        // basic auth
        $auth = $this->API_username . ":" . $this->API_password;
        $auth = base64_encode($auth);

        // set headers
        $headers = array();
        $headers[] = "X-API-KEY: " . ($this->apikey);
        $headers[] = "Authorization: Basic " . ($auth);
        

        // setup request
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        if ($method_type == "POST") curl_setopt($curl_handle, CURLOPT_POST, 1);
        else curl_setopt($curl_handle, CURLOPT_POST, 0);

        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);	// add in headers set above

        $miss = false;
        if ($use_cache === true) {
            $key = md5(serialize(array($method_name, $method_type, $post_params)));

            $result = $this->cache_get($key);
            if (isset($result->status))	$this->error_handle($result);
            if ($result !== false && $result !== NULL) {
                $this->cache_hits++;
                return $result;
            }
        }

        
        
        $this->cache_misses++;
        $buffer = curl_exec($curl_handle);
        if ($buffer === false) {
            $this->error_handle( curl_error($curl_handle));
            exit;            
        }
        curl_close($curl_handle);

        
        $result = json_decode($buffer);

        if ($use_cache && $result !== NULL) {
            $this->cache_save($key, $result);
        }


        return $result;
    }


    protected function error_handle($result) {

        throw new Exception($result);

    }

    
    /*
     * Some caching functions
     * 
     * Check memcached.php for cache parameters and settings
     * 
     * If you're using this library outside of Code Ignitor then you'll need to rewrite or bypass these 3 methods
     */
    protected function cache_init() {
        if ($this->ci->config->config['use_cache'] == true)
            $this->ci->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file'));
    }
    protected function cache_save($key, $data) {
        if ($this->ci->config->config['use_cache'] == true)
            $this->ci->cache->save($key, $data, $this->ci->config->config['cache_save_seconds']);
    }
    protected function cache_get($key) {
        if ($this->ci->config->config['use_cache'] == true)
            return $this->ci->cache->get($key);
        else
            return false; // always miss if cache disabled
    }


}