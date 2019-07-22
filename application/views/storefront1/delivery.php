<?php
$needssl = true;
$thispage="delivery";
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
	          
	          <div class="w100 clearfix">
	            <div class="row userInfo">
	              <div class="col-lg-12">
				  	<h2 class="block-title-2"> 		              
				  	<?php if ($product_type == 'physical') {?>Please enter your information<? } ?>
			    	<?php if ($product_type == 'email') {?>Please enter your information<? } ?>
			    	<?php if ($product_type == 'download') {?>Please enter your information<? } ?>		   
          
	               </h2>
	              </div>
                  
                  <form method="post" id='addressform' action="<?php echo $_SERVER['PHP_SELF']; ?>" class="cart_form details">
                     <input type="hidden" name="action" value="address">
                     <input type="hidden" name="promoid" value="<?php echo $promoid; ?>">
		              
	                <div class="col-xs-12 col-sm-6">
	                  <div class="form-group required <?php if (in_array("Email", $errfields)) echo "has-error"; ?>">
	                    <label for="Email" class="control-label">Email <sup>*</sup></label>
						<input type="email" name="Email" id="Email"  value="<?php echo GetAcctField("Email"); ?>" class="form-control"/>	                    
						<?php if ($redemption->cart_has_items("grab")) { ?><p class="help-block">A valid email address is required to send confirmation of your subscription</p>
						<?php } else if ($redemption->cart_has_only_items("gt")) {?><p class="help-block">Your reward will be emailed to you.  Please enter a valid email address.</p>
						<?php } else if ($redemption->cart_has_only_items("it") || $redemption->cart_has_only_items("ig")) {?><p class="help-block">A valid email address is required to send confirmation of your download</p>
						<?php } else if ($redemption->cart_has_only_items("MTG") || $redemption->cart_has_only_items("MTG")) {?><p class="help-block">A valid email address is required to send confirmation of your redemption</p><? } ?>	                    
	                  </div>                
	                  <div class="form-group required <?php if (in_array("FirstName", $errfields)) echo "has-error"; ?>">
	                    <label for="FirstName" class="control-label">First Name <sup>*</sup> </label>
	                    <input type="text" name="FirstName" class="form-control" value='<?php echo GetAcctField("FirstName"); ?>'/>
	                  </div>
	                  <div class="form-group required <?php if (in_array("LastName", $errfields)) echo "has-error"; ?>">
	                    <label for="LastName" class="control-label">Last Name <sup>*</sup> </label>
	                    <input type="text" name="LastName" class="form-control" value='<?php echo GetAcctField("LastName"); ?>'/>
	                  </div>
	                </div>
	                <div class="col-xs-12 col-sm-6">
					  <?php if (!$redemption->cart_has_only_items("it") && !$redemption->cart_has_only_items("ig")) { // these items do not require an address ?>		                
	                  <div class="form-group required <?php if (in_array("Addr1", $errfields)) echo "has-error"; ?>">
	                    <label for="Addr1" class="control-label">Address <sup>*</sup> </label>
						<input type="text" id="Addr1" name="Addr1" class="form-control" value='<?php echo GetAcctField("Addr1"); ?>'/>
	                  </div>
	                  <div class="form-group">
	                    <label for="Addr2" class="control-label">Apt. / Room / Suite</label>
	                    <input type="text" id="Addr2" name="Addr2"  class="form-control" value='<?php echo GetAcctField("Addr2"); ?>'/>
	                  </div>		                
	                  <div class="form-group required <?php if (in_array("City", $errfields)) echo "has-error"; ?>">
	                    <label for="City" class="control-label">City <sup>*</sup> </label>
						<input type="text" id="City" name="City" class="form-control" value='<?php echo GetAcctField("City"); ?>'/>	                    
	                  </div>
	                  <div class="form-group required <?php if (in_array("State", $errfields)) echo "has-error"; ?>">
	                    <label for="State" class="control-label"><?php echo $redemption->get_skin_attr("statefieldname"); ?>: <sup>*</sup></label>
			    		<select name="State" id="State" class="form-control">
			    		  <option value=''>Select a <?php echo strtolower($redemption->get_skin_attr("statefieldname")); ?></option>
 						  <?php DisplayStatesOptions("State", true, GetAcctField("State")); ?>
 			    		</select>
	                  </div>
	                  <div class="form-group required <?php if (in_array("PostalCode", $errfields)) echo " error"; ?>">
	                    <label for="PostalCode" class="control-label"><?php echo $redemption->get_skin_attr("zipfieldname"); ?>: <sup>*</sup> </label>
	                    <input type="text" id="PostalCode" name="PostalCode" class="form-control" value='<?php echo GetAcctField("PostalCode"); ?>'/>	                    
	                  </div>
					<? } else { ?>
                    <input type='hidden' name='CompanyName' value='na' />
                    <input type='hidden' name='Addr1' value='na' />
                    <input type='hidden' name='Addr2' value='na' />
                    <input type='hidden' name='City' value='na' />
                    <input type='hidden' name='State' value='na' />
                    <input type='hidden' name='PostalCode' value='na' />
                    <?php } ?>						                
	                </div>	                
	              </form>
	            </div>
	            <!--/row end--> 
	            
	          </div>
	          <div class="cartFooter w100">
	            <div class="box-footer">
	              <div class="pull-left"> <a class="btn btn-default" href="cart.php?promoid=<?php echo $promoid; ?>"> <i class="fa fa-arrow-left"></i> &nbsp; Back to Cart</a> </div>
	              <div class="pull-right"> <a class="btn btn-primary btn-small " href="javascript:document.forms.addressform.submit();"> Review & Confirm &nbsp; <i class="fa fa-arrow-circle-right"></i> </a> </div>
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
