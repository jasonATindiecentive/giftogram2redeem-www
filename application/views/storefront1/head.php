<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
<?php switch ($thispage) {
	case "home": echo "Home - "; break;	
	case "results": echo "Results - "; break;	
	case "detail": if (strlen(trim($ProductDetail->ProductTitle)) > 0) echo encode_text($ProductDetail->ProductTitle) . " - "; break;	
	case "cart": case "delivery": case "confirm": echo "Shopping Cart - "; break;
	case "orderhistory": echo "Your order - "; break;
}

if ($thispage <> "detail")
	echo $redemption->objSkin->ALLPAGES_TITLE;
else {
	echo $redemption->objSkin->DETAILPAGE_TITLE;
}
?>
</title>

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo PL_ASSETS; ?>storefront1/assets/ico/magazines/favicon-16x16.png">

<link href="<?php echo PL_ASSETS; ?>storefront1/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/core.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/<?php echo $redemption->objSkin->PRODUCT_CSS; ?>" rel="stylesheet">

<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/owl.carousel.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/owl.theme.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/ion.checkRadio.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/ion.checkRadio.cloudy.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/jquery.minimalect.min.css" rel="stylesheet">
<link href="<?php echo PL_ASSETS; ?>storefront1/assets/css/jquery.mCustomScrollbar.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo PL_ASSETS; ?>storefront1/assets/js/jquery/1.8.3/jquery.js"></script>
<script type="text/javascript" src="<?php echo PL_ASSETS; ?>storefront1/assets/bootstrap/js/bootstrap.min.js"></script>

<!-- Just for debugging purposes. -->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<script>
    paceOptions = {
    	elements: true
    };
</script>
<script src="<?php echo PL_ASSETS; ?>storefront1/assets/js/pace.min.js"></script>

<?php if (strlen(trim($redemption->objSkin->BRANDED_CSS)) > 0) { ?>
<style>
	<?php echo $redemption->objSkin->BRANDED_CSS; ?>
</style>
<?php } ?>

<?php if (strlen(trim($redemption->objSkin->EXTRA_HEADERS_HTML)) > 0) { ?>
	<?php echo $redemption->objSkin->EXTRA_HEADERS_HTML; ?>
<?php } ?>

</head>