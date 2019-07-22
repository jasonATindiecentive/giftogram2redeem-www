<?php
$needssl = "dontcare";
$thispage="ordershistory";
include_once dirname(__FILE__) . "/../controller/handler.php"
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<?php 
	include 'head.php'
?>

<body>

<?php include 'enter_code.php' ?>

<?php include 'navigation.php' ?>

<div class="main-container-wrapper">

	<div class="container main-container headerOffset">
	
	  <?php include 'breadcrumb.php' ?>
	  
	  <div class="row">
	    <div class="col-lg-9 col-md-9 col-sm-7">
	      <h2 class="section-title-inner"><i class="fa fa-list"></i> Order History</h2>
	    </div>
	    <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
	      <h5 class="caps"><a href="storefront.php?promoid=<?php echo $promoid; ?>"><i class="fa fa-chevron-left"></i> Back to shopping </a></h5>
	    </div>
	  </div> <!--/.row-->
	  
	  <div class="row">
	    <div class="col-lg-9 col-md-9 col-sm-12">
	      <div class="row userInfo">
	        <div class="col-xs-12 col-sm-12">
	          <div class="cart-review cartContent w100">
			  	<p>Here is a summary of your orders:</p>
	          	<div class="table-responsive">
		            <table class="delay-load cartTable productTable" style="width:100%">
		              <thead>
		                <tr class="CartProduct cartTableHeader">
		                  <td style="width:15%">Product</td>
		                  <td style="width:60%">&nbsp;</td>
		                  <td style="width:10%">Order #</td>
		                  <td style="width:15%">Date</td>
		                </tr>              
		              </thead>
		              <tbody>
					  <?php $i=2;
					  $Orders->ReWind();
					  while ($Order = $Orders->fetch()) {
					  	$OrderItems = $redemption->catalog->GetOrderItems($Order['RedemptionHistoryID']);
						  $total = 0;
						  while ($Item = $OrderItems->fetch()) {
								$Product = $redemption->catalog->GetProduct($Item['CatalogType'], $Item['ProductID']);
								
							
							if (strlen($Item['ProductItemID']) > 0) {
								$ProductItem = $redemption->catalog->GetProductItem($Item['CatalogType'], $Item['ProductID'], $Item['ProductItemID']);
								$total += $ProductItem['CreditCost'] * $Item['Quantity'];
								$cost = $ProductItem['CreditCost'];
							} else if (strlen($Item['ProductOptionID'])) {
								$ProductOption = $redemption->catalog->GetProductOption($Item['CatalogType'], $Item['ProductID'], $Item['ProductOptionID']);
								$total += $ProductOption['CreditCost'];
								$cost = $ProductOption['CreditCost'];
							} else {
								$total += $Product['CreditCost'] * $Item['Quantity'];
								$cost = $Product['CreditCost'];
							}
						
					  	?>			              
		                <tr class="CartProduct">
		                  <td  class="CartProductThumb">
			                  <div>
				                  <img src="<?php echo str_replace("http://", "https://", $Product['BrowseImage']); ?>" alt="<?php echo encode_text($Product['Title']); ?>">
				              </div>
				          </td>
		                  <td>
			                <div class="CartDescription">
		                      <h4 style="padding-bottom: 5px;"><?php echo utf8_encode($Product['Title']); ?></h4>
					  		  <?php if (strlen($Product['ArtistName']) > 0) { ?>
                              <h5 style="padding-bottom: 5px;">by <?php echo $redemption->ShowAuthors($Product['ArtistName'], false); ?></h5>
                              <?php } ?>
							  <ul>
							  <?php
							  ?>
							  
							  <li>

							      <div class="info" style="float:left;">
							          <ul>
							              <li style="padding-bottom: 5px;"><?php echo $redemption->DisplayAmount($cost); ?></li>
							              <li>
							  	<?php 	if ($Product['FulfillMethod'] == 'ship') { ?>

							      <?php } else if ($Item['CatalogType'] == 'ig') {
							  			$row = $redemption->catalog->objIngramCatalog->GetRedemptionHistory($Item['RedemptionHistoryItemID']);
							  		
							  		?>
							         
							  	      <a class="btn btn-primary" href='<?php echo $row['uniquedownloadURL']; ?>' target='_blank'>
							              <span>Download Now</span>
							          </a>
							      <?php } else if ($Product['CatType'] == 'gt') { 
							  		if ($redemption->objSkin->GIFTTANGO_ShowGiftLink == 'yes') { // show link if this promo is set up to
							  		?>
							         
							         
							        <?php
							  	   
							  	   // The URL for this virtual gift card is stored in gifttango.RedemptionHistory
							  	   
							  		$row = $redemption->catalog->objEGiftCardCatalog->GetRedemptionHistory($Item['RedemptionHistoryItemID']);
							  		$virtual_cert_link_string = $row['virtual_cert_link_string'];
									
							  		
							  		if ($row === NULL) { ?>
							  		<div class="error">
							             <span>This order has been cancelled</span>
							        </div>
							  			
							  		<?php } else {
							  				
							  			// if the link is empty then it means it's a test/sample code, display the sample cert link
							  			
							  			if (strlen($virtual_cert_link_string) == 0)
							  			$virtual_cert_link_string = $Product['SampleCertLink'];
							  			
							  			// virtual_cert_link_string might contain more than one link, although this is rare..
							  			$links = explode("||", $virtual_cert_link_string);
							  				foreach ($links as $link) {
							  					$a = explode("?r=", $link);
												if (count($a) > 1) $link = $a[0] . "?r=" . urlencode($a[1]);
							  					?>
							  				<div>
							  				<a class="btn btn-egc" href='<?php echo $link; ?>' target='_blank'>
							  					Open eGift Card
							  				</a>
							  				</div>
							  				<?php } ?>
							  			<?php } ?>
							  		<?php } else { ?>                            
							          	Your eGift card has been emailed to <?php echo $redemption->Account[Email]; ?>.
							          <?php } ?>
							  
							      <?php } else if ($Item['CatalogType'] == 'it') { 
							  		$parts = 0;
							  		for ($i = 1; $i <= 6; $i++) {
							  			$field = "WorkoutPart{$i}URL";
							  			if (strlen($ProductItem[$field]) > 1) $parts++;
							  		}
							  		$part = 1;
							  		for ($i = 1; $i <= 6; $i++) {
							  			$field = "WorkoutPart{$i}URL";
							  			if (strlen($ProductItem[$field]) > 1) {
							  
							  				$row = $redemption->catalog->objiTrainCatalog->GetRedemptionHistory($Item['RedemptionHistoryItemID']);
							  				
							  				if ($row['available'] == '1') {
							  				?>
							  				<a class="btn btn-primary" href='<?php echo str_replace("standard/common", "", $row['uniquedownloadURL']). "&part=$i"; ?>'>Download <? if ($parts > 1) { echo " Part " . $part++; } ?></a>
							  				<?php } else { ?>
							  				<div class="error">
							  					<span>This item has already been downloaded.</span>
							  				</div>
							  				<?php }
							  			}
							  		}
							  		$ProductItem['WorkoutPDF'] = trim($ProductItem['WorkoutPDF']);
							  	if (strlen($ProductItem['WorkoutPDF']) > 0 && $ProductItem['WorkoutPDF'] <> "0") { ?>
							  		<a class="btn btn-primary" href='<?php echo str_replace("standard/common", "", $row['uniquedownloadURL']). "&part=pdf"; ?>'>Download PDF</a>
							  	<?php } 
							  		$ProductItem['WorkoutVideo1URL'] = trim($ProductItem['WorkoutVideo1URL']);
							  		if (strlen($ProductItem['WorkoutVideo1URL']) > 0 && $ProductItem['WorkoutVideo1URL'] <> "0") { ?>
							  			<a class="btn btn-primary" href='<?php echo str_replace("standard/common", "", $row['uniquedownloadURL']). "&part=video1"; ?>'>Download Video</a>
							  		<?php } 
							  		$ProductItem['WorkoutVideo2ViewOnlyURL'] = trim($ProductItem['WorkoutVideo2ViewOnlyURL']);
							  		if (strlen($ProductItem['WorkoutVideo2ViewOnlyURL']) > 0 && $ProductItem['WorkoutVideo2ViewOnlyURL'] <> "0") { ?>
							  			<a class="btn btn-primary" href='<?php echo str_replace("standard/common", "", $row['uniquedownloadURL']). "&part=video2"; ?>'>Download Video</a>
							  		<?php } 
							  		
							  		?>
							      <?php } else { ?>
							         This is a digital reward item that you can redeem instantly.
							          <a target='_blank' class="btn btn-primary" href='http://www.prizelabs.com/platforms/redeem/?promoid=<?php echo urlencode($Product['PrizePIN_PromotionID']); ?>&pin=<?php echo urlencode($Item['PrizePIN']); ?>&email=<?php echo urlencode($Order['EmailAddr']); ?>&action=pin'>Display Reward</a>
							      <?php }
							  	 ?>
                                  </li>
                              </ul>
		                    </div>
		                  </td>
		                  <td>
						  
						  <?php echo htmlentities($redemption->Account['AccountIdentifier'] . "-" . $Order['RedemptionHistoryID']); ?></td>
		                  <td><?php echo htmlentities($Order['Formatted_TS']); ?></td>
		                </tr>
						<?php $i++;
						  }
						} ?>
		              </tbody>
		            </table>
	          	</div> <!--/ table-responsive -->
	          </div>
	          <!--cartContent-->	          
	          
	          <div class="w100 clearfix">
	            <div class="row userInfo">
	              <div class="col-lg-12">
					  <div class="panel panel-default">
					  	<div class="panel-heading">
					  	  <h3 class="panel-title"><strong>Your Info</strong></h3>
					  	</div>
					  	<div class="panel-body">
					  	  <ul>
					  	    <li> <span class="address-name"> <strong><?php echo htmlentities($redemption->Account['FirstName'] . " " . $redemption->Account['LastName']); ?></strong></span></li>
					  		<?php if ($redemption->Account['Addr1'] <> "na") { ?>
					  		<li><?php echo htmlentities($redemption->Account['Addr1']); ?></li>
					  		<?php if (strlen($redemption->Account['Addr2']) > 0) { ?>
					  		<li><?php echo htmlentities($redemption->Account['Addr2']); ?></li>
					  		<?php } ?>
					  		<li><?php echo htmlentities($redemption->Account['City']); ?>, <?php echo htmlentities($redemption->Account['State']); ?> <?php echo htmlentities($redemption->Account['PostalCode']); ?></li>
					  	    <?php } ?>
					  		<li> <span> <strong>Email</strong>: <?php echo $redemption->Account['Email']; ?></span></li>
					  	  </ul>
					  	</div>
					  </div> <!-- /panel -->  
	              </div> <!-- /col-12-->
	            </div>
	            <!--/row end--> 
	            
	          </div>
	          <div class="cartFooter w100">
	            <div class="box-footer">
	              <div class="pull-right"> <a class="btn btn-primary btn-small" href="storefront.php?promoid=<?php echo $promoid; ?>"> Go Home</a> </div>
	            </div>
	          </div>
	          <!--/ cartFooter --> 
	          
	        </div>
	      </div>
	      <!--/row end--> 
	      
	    </div>
	
		<?php include 'product-checkout-notice.php' ?>
	      
	    </div>
	    <!--/rightSidebar--> 
	    
	  </div> <!--/row-->
	  
	  <div style="clear:both"></div>
	</div> <!-- /.main-container-->

</div> <!-- /main container wrapper -->

<?php include 'footer.php' ?>

<?php include 'scripts.php' ?>

</body>
</html>
