<?php



// here are some helper functions used throughout the storefront
//
// the storefrontv1 view calls some global functions which can be defined here
//
// (see also: config/autoload.php whiich pulls in this file)


if (!function_exists('encode_text')) {
    function encode_text($str)
    {
        $w = mb_detect_encoding($str, 'UTF-8', true); //true=strict mode-it's useless without this for some reason

        $str = str_replace("Â", "", $str);
        $str = str_replace("—", "-", $str);

        if ($w == "UTF-8") $str = $str; // it's already utf8 encoded
        else $str = utf8_encode($str);    // it's not utf8 (or we don't know and it's harmless to utf8encode it)


        $str = strip_tags($str, "<br/><br><li><ul><i><strong><font><span>"); // try to remove any HTML, XML tags

//	$str = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $str);	
        return $str;
    }
}
if (!function_exists('encode_text2')) {
    function encode_text2($str)
    { // same as above but don't strip_tags

        $w = mb_detect_encoding($str, 'UTF-8', true); //true=strict mode-it's useless without this for some reason
        $str = str_replace("—", "-", $str);
        $str = str_replace("�", "-", $str);

        if ($w == "UTF-8") $str = $str; // it's already utf8 encoded
        else $str = utf8_encode($str);    // it's not utf8 (or we don't know and it's harmless to utf8encode it)
//	$str = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $str);	
        return $str;
    }
}