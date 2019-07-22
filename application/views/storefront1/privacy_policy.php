<?php

$thispage="other";
$needssl = "dontcare";

include_once dirname(__FILE__) . "/../controller/handler.php"


?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<?php 
	include 'head.php';
?>

<body>

<?php include 'navigation.php' ?>

<div class="main-container-wrapper" style='padding-bottom: 25px;'>

	<div class="container main-container headerOffset">



	<?php echo utf8_encode(
				str_replace("_STARTDATE_", $redemption->row_promo['FORMATTED_StartDate'], 				   
							$redemption->objSkin->PrivacyHTML
						)
		); ?>
        
        
        </div>
        </div>
<?php include 'footer.php' ?>

<?php include 'scripts.php' ?>

</body>
</html>