<?php
/*$needssl = true;*/
$thispage="confirm";
include_once dirname(__FILE__) . "/../controller/handler.php"
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<?php include 'head.php'; ?>

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
	          	<div class="table-responsive">
		            <table class="delay-load cartTable productTable" style="width:100%">
		              <thead>
		                <tr class="CartProduct cartTableHeader">
		                  <td style="width:15%">Product</td>
		                  <td style="width:55%">&nbsp;</td>
		                  <td style="width:10%">Qty.</td>
		                  <td style="width:10%">Total</td>
		                  <td style="width:10%">&nbsp;</td>
		                </tr>              
		              </thead>
		              <tbody>
			              
						<?php 
						$total = 0;
						for ($i = 0; $i < $redemption->count_items_in_cart(); $i++) {
                        $CartItem = $redemption->get_cart_item($i);
						
                        $Product = $CartItem[Product];
						$ProductItem = $CartItem['ProductItem'];
						$ProductOption = $CartItem['ProductOption'];
						
						if ($ProductItem !== NULL)
							$cost = $ProductItem['CreditCost'];
						else if ($ProductOption !== NULL)
							$cost = $ProductOption['CreditCost'];
						else 
							$cost = $Product['CreditCost'];
						
                        $toggle = !$toggle;
						
						$total += $cost * $CartItem['qty'];
						?>			                 
		                <tr class="CartProduct">
		                  <td  class="CartProductThumb"><div> <img src="<?php echo str_replace("http://", "https://", $Product['BrowseImage']); ?>" alt="<?php echo encode_text($Product['Title']); ?>"> </div></td>
		                  <td>
			                <div class="CartDescription">
		                      <h4><?php echo encode_text($Product['Title']); ?></h4>
                              <?php if (strlen($ProductItem['Title']) > 0) { ?>
                              	<p><?php echo encode_text($ProductItem['Title']); ?></p>
                              <?php } else if (strlen($ProductOption['Title']) > 0) { ?>
                              	<p><?php echo encode_text($ProductOption['Title']); ?></p>
                              <?php } ?>
							  <?php if (strlen($Product['ArtistName']) > 0) { ?>
                              	<h5>by <?php echo $redemption->ShowAuthors($Product['ArtistName']); ?></h5>
                              <?php } ?>                              	                      
		                    </div>
		                  </td>
		                  <td>
			                  <?php echo $CartItem['qty']?>		                  
		                  </td>
		                  <td class="price"><?php echo $redemption->DisplayAmount($cost * $CartItem['qty']); ?></td>
						  <td><a href="cart.php?promoid=<?php echo $promoid; ?>" class="btn btn-primary">Edit</a></td>
		                </tr>
		                <?php } ?>		                
		              </tbody>
		            </table>
	          	</div> <!--/ table-responsive -->
	          </div>
	          <!--cartContent-->	          
	          
	          <div class="w100 clearfix">
	            <div class="row userInfo">
	              <div class="col-lg-12">
	                <h2 class="block-title-2">
		    			<?php if ($product_type == 'physical') {?>Please confirm your order and personal info<?php }?>
		    			<?php if ($product_type == 'email') {?>Please confirm your order and email delivery info<?php }?>
		    			<?php if ($product_type == 'download') {?>Please confirm your order and contact info<?php }?>		                
	                </h2>
	              </div>
	              <div class="col-lg-12">
					  <div class="panel panel-default">
					  	<div class="panel-heading">
					  	  <h3 class="panel-title"><strong>My Info</strong></h3>
					  	</div>
					  	<div class="panel-body">
					  	  <ul>
					  	  <?php if (!$redemption->cart_has_only_items("it") && !$redemption->cart_has_only_items("ig")) { // these items do not require an address ?>
					  	  	<li> <span class="address-name"> <strong><?php echo $MyAccount['FirstName'] . " " . $MyAccount['LastName']; ?></strong></span></li>
					  	    <li> <span class="address-line1"><?php echo $MyAccount['Addr1']; ?></span></li>
					  	    <?php if (strlen($MyAccount['Addr2']) > 0) {?><li> <span class="address-line2"><?php echo $MyAccount['Addr2']; ?></span></li><?php } ?>
					  	    <li> <span class="address-line3"><?php echo $MyAccount['City'] . ", " . $MyAccount['State'] . $MyAccount['PostalCode'];?></span></li>
					  	    <?php } ?>
					  	    <?php if (strlen($MyAccount['Email']) > 0) { ?>
							<li> <span> <strong>Email</strong>: <?php echo $MyAccount['Email'];?></span></li>
					  		<?php } ?>
					  	  </ul>
					  	</div>
					  	<div class="panel-footer panel-footer-address"><a href="delivery.php?promoid=<?php echo $promoid; ?>" class="btn btn-primary">Edit</a></div>
					  </div> <!-- /panel -->  
	              </div> <!-- /col-12-->
	            </div>
	            <!--/row end--> 
	            
	          </div>
	          <div class="cartFooter w100">
	            <div class="box-footer">
	              <div class="pull-left"> <a class="btn btn-default" href="delivery.php"> <i class="fa fa-arrow-left"></i> &nbsp; Go Back</a> </div>
	              <div class="pull-right"> <a class="btn btn-primary btn-small" href="?action=placeorder">Complete Checkout &nbsp; <i class="fa fa-arrow-circle-right"></i> </a> </div>
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
