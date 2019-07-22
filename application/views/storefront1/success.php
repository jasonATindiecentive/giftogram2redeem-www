<?php
/*$needssl = true;*/
$thispage="orderhistory";
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
	      <h2 class="section-title-inner"><i class="fa fa-shopping-cart"></i> Checkout</h2>
	    </div>
	    <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
	      <h5 class="caps"><a href="storefront.php?promoid=<?php echo $promoid; ?>"><i class="fa fa-chevron-left"></i> Back to shopping </a></h5>
	    </div>
	  </div> <!--/.row-->
	  
	  <div class="row">
	    <div class="col-lg-9 col-md-9 col-sm-12">
	      <div class="row userInfo">
	        <div class="col-xs-12 col-sm-12">
	          <div class="w100 clearfix">
				  <?php include 'order-steps.php' ?>			  
	          </div>
	          
	          <div class="cart-review cartContent w100">
	          	<h3>Thank you!</h3>
			  	<?php if ($is_email_confirm !== true && $IsTest !== true) { ?>
			  		<?php if (in_array('ig', $has_ProductTypes)) {  // do we have ebook items ?>
			  	    	<p>A copy of your download link and order confirmation has been sent to <?php echo htmlentities($Order['Email']); ?>.  The subject line is: "<?php echo htmlentities($redemption->objSkin->_ORDER_EMAIL_SUBJECT); ?>".  You may need to add "prizelabs.com" to your safe senders list or address book to prevent this email from being blocked. If you would like to access your eBook on multiple devices simply open the email and download to the device of your choice.</p><p><strong>You may return to this site and re-enter your reward code at any time to re-display this information.</strong></p>
			  	    <?php } else { ?>
			  	    	<p>A copy of your order confirmation has been sent to <?php echo htmlentities($Order['Email']); ?>.  The subject line is: "<?php echo htmlentities($redemption->objSkin->_ORDER_EMAIL_SUBJECT); ?>."  You may need to add "prizelabs.com" to your safe senders list or address book to prevent this email from being blocked.</p><p><strong>You may return to this site and re-enter your reward code at any time to re-display this information.</strong></p>			  	
			  	    <?php } ?>
			  	<?php } ?>
	          	<div class="table-responsive">
		            <table class="delay-load cartTable productTable" style="width:100%">
		              <thead>
		                <tr class="CartProduct cartTableHeader">
		                  <td style="width:15%">Product</td>
		                  <td style="width:60%">&nbsp;</td>
		                  <td style="width:25%">&nbsp;</td>
		                </tr>              
		              </thead>
		              <tbody>
						<?php 
						$total = 0;
						while ($Item = $OrderItems->fetch()) {
							
						$Product = $redemption->catalog->GetProduct($Item['CatalogType'], $Item['ProductID']);
						if (strlen($Item['ProductItemID']) > 0 && $Item['is_demo'] !== true) {	
							$ProductItem = $redemption->catalog->GetProductItem($Item['CatalogType'], $Item['ProductID'], $Item['ProductItemID']);
							$total += $ProductItem['CreditCost'] * $Item['qty'];
						} else if (strlen($Item['ProductOptionID']) > 0 && $Item['is_demo'] !== true) {
							
							$Product = $redemption->catalog->GetProductOption($Item['CatalogType'], $Item['ProductID'], $Item['ProductOptionID']);
							$total += $Product['CreditCost'] * $Item['qty'];
						} else {
							$total += $Product['CreditCost'] * $Item['qty'];
						}						
						?>
		                <tr class="CartProduct">
		                  <td  class="CartProductThumb"><div> <img src="<?php echo str_replace("http://", "https://", $Product['BrowseImage']); ?>" alt="<?php echo encode_text($Product['Title']); ?>"></div></td>
		                  <td ><div class="CartDescription">
		                      <h4><?php echo utf8_encode($Product['Title']); ?></h4>
					  		  <?php if (strlen($Product['ArtistName']) > 0) { ?>
                              <h5>by <?php echo $redemption->ShowAuthors($Product['ArtistName'], false); ?></h5>
                              <?php } ?>			                      
		                    </div>
		                  </td>
		                  <td>
						<?php 
						if ($Item['is_demo'] == true && IS_DEV !== true) { ?>
                         	<i>A demonstration reward code was
                            used to place this order.</i>
                        <?php } else if ($Product['FulfillMethod'] == 'ship') { ?>
                            <?php
                            // handle shipping status here....
                            switch ($Item[OrderStatus]) {
                                case "pending":
                                case "accepted":
                                    if ($Item[CatalogType] == CATALOGTYPE_GRABAZINES)
                                        echo "Awaiting processing";
                                    else if (strlen($Item[Est_ShipDate]) > 0)
                                        echo "Estimated Ship Date: $Item[Formatted_Est_ShipDate]";
                                    else
                                        ;
                                        //echo "Awaiting shipment details";
                                    break;
                                case "rejected":
                                    echo "Sorry, this item is not available. Your account has been credited.";
                                    break;
                                case "fulfilled":
                                    if ($Item[CatalogType] == CATALOGTYPE_GRABAZINES)
                                        echo "Subscription Submitted to publisher";
                                    else
                                        echo "This item has shipped on $Item[Formatted_ShippedTS]";
                                    break;
                            }
                            ?>
                        <?php } else if ($Product['CatType'] == 'gt') { 
							if ($redemption->objSkin->GIFTTANGO_ShowGiftLink == 'yes') { // show link if this promo is set up to
							?><?php
						   
						   // The URL for this virtual gift card is stored in gifttango.RedemptionHistory
						   
							$row = $redemption->catalog->objEGiftCardCatalog->GetRedemptionHistory($Item['RedemptionHistoryItemID']);
							
							$virtual_cert_link_string = $row['virtual_cert_link_string'];
							
							// if the link is empty then it means it's a test/sample code, display the sample cert link
							
							if (strlen($virtual_cert_link_string) == 0)
							$virtual_cert_link_string = $Product['SampleCertLink'];
							
						    // virtual_cert_link_string might contain more than one link, although this is rare..
						   	$links = explode("||", $virtual_cert_link_string);
							
								foreach ($links as $link) {
//									$a = explode("?r=", $link);
//									$link = $a[0] . "?r=" . urlencode($a[1]);
									
									?>
								<a class="btn btn-egc" href='<?php echo $link; ?>' target='_blank' style="">
									Open eGift Card
								</a>
                                <br/>
		
								<?php } ?>
							<?php } else { ?>                            
                            	Your eGift card has been emailed to <a href="mailto:<? echo $Order['Email']; ?>"><?php echo $Order[Email]; ?></a>.
                            <?php } ?>

                        <?php } else if ($Item['CatalogType'] == 'ig') {
								$row = $redemption->catalog->objIngramCatalog->GetRedemptionHistory($Item['RedemptionHistoryItemID']);
							
							?>
							<a class="btn btn-primary" href='<?php echo $row['uniquedownloadURL']; ?>' target='_blank'>
                                Download Now
                            </a>
                      <?php } else if ($Item['CatalogType'] == 'it') { 
							$parts = 0;
							for ($i = 1; $i <= 6; $i++) {
								$field = "WorkoutPart{$i}URL";
								if (strlen($ProductItem[$field]) > 1) $parts++;
							}
							$part=1;
							for ($i = 1; $i <= 6; $i++) {
								$field = "WorkoutPart{$i}URL";
								if (strlen($ProductItem[$field]) > 1) {

									$row = $redemption->catalog->objiTrainCatalog->GetRedemptionHistory($Item['RedemptionHistoryItemID']);
									
									if ($row['available'] == '1') {
									?>
									<a class="btn btn-primary" href='<?php echo $row['uniquedownloadURL']. "&part=$i"; ?>' style='margin-bottom: 5px; '>
										Download <?php if ($parts > 1) { ?> Part <?php echo $part++; ?> <?php } ?>
									</a>
                                    <br/>
									<?php } else { ?>
										This item has already been downloaded.
									<?php }
								}
							}
							$ProductItem['WorkoutPDF'] = trim($ProductItem['WorkoutPDF']);
							if (strlen($ProductItem['WorkoutPDF']) > 0 && $ProductItem['WorkoutPDF'] <> "0") { ?>
								<a class="btn btn-primary" href='<?php echo $row['uniquedownloadURL']. "&part=pdf"; ?>'>
									Download PDF
								</a>
							<?php } 
							$ProductItem['WorkoutVideo1URL'] = trim($ProductItem['WorkoutVideo1URL']);
							if (strlen($ProductItem['WorkoutVideo1URL']) > 0 && $ProductItem['WorkoutVideo1URL'] <> "0") { ?>
								<a class="btn btn-primary" href='<?php echo $row['uniquedownloadURL']. "&part=video1"; ?>'>
									Download Video
								</a>
							<?php $videopart2 = " 2";} 
							$ProductItem['WorkoutVideo2ViewOnlyURL'] = trim($ProductItem['WorkoutVideo2ViewOnlyURL']);
							if (strlen($ProductItem['WorkoutVideo2ViewOnlyURL']) > 0 && $ProductItem['WorkoutVideo2ViewOnlyURL'] <> "0") { ?>
								<a class="btn btn-primary" href='<?php echo $row['uniquedownloadURL']. "&part=video2"; ?>'>
									Download Video <?php echo $videopart2; ?>
								</a>
							<?php } 
				
							
                        } else { ?>
                           This is a digital reward item that you can redeem instantly.<br/>
                            <a target='_blank' class="btn btn-primary" href='http://www.prizelabs.com/platforms/redeem/?promoid=<?php echo urlencode($Product['PrizePIN_PromotionID']); ?>&pin=<?php echo urlencode($Item['PrizePIN']); ?>&email=<?php echo urlencode($Order['Email']); ?>&action=pin'>
                                Display Reward
                            </a>
                        <?php } ?>
		                  </td>
		                </tr>
		                <?php } ?>


		              </tbody>
		            </table>
	          	</div> <!--/ table-responsive -->
	          </div>
	          <!--cartContent-->	          
	          
	          <div class="w100 clearfix">
	            <div class="row userInfo">
							<?php if (in_array('gb', $has_ProductTypes)) {  // all shipped item types ?>
				              <div class="col-lg-12">
				                <h2 class="block-title-2">Your Item Will Be Sent To This Address</h2>
				              </div>							
				              <div class="col-lg-12">
								  <div class="panel panel-default">							
									  	<div class="panel-heading">
									  	  <h3 class="panel-title"><strong>Shipping To:</strong></h3>
									  	</div>
									  	<div class="panel-body">
										  	<ul>
											  	<li><?php echo $Order['FirstName'] . " " . $Order['LastName']; ?></li>
												<li><?php echo $Order['Addr1'] ?></li>
												<?php if (strlen($Order['Addr2']) > 0) { ?>
			                                    <li><?php echo $Order['Addr2'] ?></li>
												<?php } ?>
												<li><?php echo $Order['City'] . ", " . $Order['State'] . " " . $Order['PostalCode']; ?></li>										  						<li><?php echo "<strong>E-mail:</strong> " . $Order['Email']; ?></li>	
											  	
										  	</ul>														
									  	</div> <!-- /panel-body -->
								  </div> <!-- /panel -->
				              </div> <!-- /col-12-->
							<?php } else if (in_array('ig', $has_ProductTypes)) {  // ebooks ?>
				              <div class="col-lg-12">
				                <h2 class="block-title-2">How To Download Your eBook</h2>
				              </div>							
				              <div class="col-lg-12">
								  <div class="panel panel-default">							
									  	<div class="panel-heading">
									  	  <h3 class="panel-title"><strong>Instructions:</strong></h3>
									  	</div>
									  	<div class="panel-body">
									  		<p>New to the eBook community? Don't worry, we've got you covered.  Below are some handy instructions on how to download and set up your eBook:</p>
									  		<ol>
									  			<li>
									  				<a href='http://www.prizelabs.com/ebooks/createadobeid/' target='_blank'>
									  			    	Set up an Adobe ID
									  			     </a>
									  			</li>
									  			<li>Download appropriate software for your device:
									  				<ul style='margin-left: 10px;'>
									  					<li>I'm on a PC:  <a href='http://www.adobe.com/products/digitaleditions/' target="_blank">Download Adobe Editions</a></li>
									  					<li>I'm on an Apple Device: <a href="http://itunes.apple.com/us/app/bluefire-reader/id394275498?mt=8&uo=4" target="itunes_store">Download Bluefire Reader</a></li>
									  					<li>I'm on a tablet or DROID operating system: <a href="http://www.aldiko.com" target="_new">Download Aldiko</a></li>
									  					<li>I don't see my device:
									  					<a href='https://digitalchoice.zendesk.com/entries/21193103-how-do-i-know-if-my-device-is-compatible' target='_blank'>
									  						View a complete list of compatible devices and software 
									  					</a><br/>
									  					*Note that our eBooks do not work on Kindle e-readers. 
									  					</li>
									  				</ul>
									  			</li>
									  			<li>Download your eBook from the green button above that says "Download Now"</li>
									  			
									  			<li>Your computer or device will prompt you to choose the application to open your eBook.  Choose the application, and you're all set! </li>
									  		</ol>														
									  	</div> <!-- /panel-body -->
								  </div> <!-- /panel -->
				              </div> <!-- /col-12-->							
                            <?php } else if (in_array('it', $has_ProductTypes)) { ?>
				              <div class="col-lg-12">
				                <h2 class="block-title-2">How To Download Your eBook</h2>
				              </div>							
				              <div class="col-lg-12">
								  <div class="panel panel-default">							
									  	<div class="panel-heading">
									  	  <h3 class="panel-title"><strong>Instructions:</strong></h3>
									  	</div>
									  	<div class="panel-body">
									  		<p>Download you eBook from the green button(s) above that says "Download"</p>
													
									  	</div> <!-- /panel-body -->
								  </div> <!-- /panel -->
				              </div> <!-- /col-12-->
				              
							<?php } else { // everything else ?>
                                    <!-- <p>This order contains items that you may use instantly. Download links are displayed above
                                    <?php if ($IsTest !== true) { ?>
                                    , and have also been emailed to the following email address:</p> -->
                                    
                                    <?php /* I don't know that we need any of this here 
                                    <p>
                                <?php echo $Order['Email'] . "<br>"; ?>
                                </p>
                                <p>You may also return to this site and re-enter your reward code any time to re-display this information.</p>
                                */ ?>
                                <?php } else echo "."; ?>
                            <?php } ?>

	            </div>
	            <!--/row end--> 
	            
	          </div>
	          <div class="cartFooter w100">
	            <div class="box-footer">
				<?php if ($product_type == 'download' && $is_email_confirm !== true) {?>
				<div class="pull-left download_btn_ctn"> <a class="btn btn-primary btn-small" href="#">Download Your Files</a> </div>
				<?php }	?>
				<?php if ($is_email_confirm !== true) { ?>		            
				  <div class="pull-left"> <a class="btn btn-default btn-small" href="javascript:window.print();">Print This Page</a> </div>
	              <div class="pull-right"> <a class="btn btn-primary btn-small" href="storefront.php?promoid=<?php echo $promoid; ?>"> Go Home</a> </div>
	            <? } ?>
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
