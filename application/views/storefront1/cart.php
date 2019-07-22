<?php
$thispage="cart";

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

<div class="master-wrapper">

	<?php include 'enter_code.php' ?>
	
	<?php include 'navigation.php' ?>    
	
	<div class="main-container-wrapper">
	
		<div class="container main-container headerOffset">
		
		  <?php include 'breadcrumb.php' ?>    
		  
		  <div class="row">
		    <div class="col-lg-9 col-md-9 col-sm-7">
		      <h2 class="section-title-inner"><i class="fa fa-shopping-cart"></i> Shopping Cart</h2>
		    </div>
		    <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
		      <h5 class="caps"><a href="<?php echo $storefront_url; ?>/home/<?php echo $idCampaign; ?>/<?php echo $hash; ?>/"><i class="fa fa-chevron-left"></i> Back to shopping </a></h5>
		    </div>
		  </div><!--/.row-->
		 
		  <div class="row">
		    <div class="col-lg-9 col-md-9 col-sm-7">
			<?php if (strlen($infomsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
				    <div class="error warning">
				    	<?php echo $infomsg; ?>
				    </div>
				</div>
			</div>
		    <?php } ?>
            
            <?php if (strlen($errmsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
				    <div class="error">
				    	<?php echo $errmsg; ?>
				    </div>
				</div>
			</div>            
		    <?php } ?>
            
            <?php if (strlen($successmsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
				    <div class="error success">
				    	<?php echo $successmsg; ?>
				    </div>
				</div>
			</div>
		    <?php } ?>
            
            <?php if (strlen($attentionmsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="error">
						<?php echo $attentionmsg; ?>
					</div>
				</div>
			</div>            
		    <?php } ?>			    
            
            <form class="cart_form"  name='updateqty' method='post'>
             <input type='hidden' name='action' value='qtyupdate' />
             
		      <div class="row userInfo">
		        <div class="col-xs-12 col-sm-12">
		          <div class="cartContent w100">
		          	<div class="table-responsive">
			            <table class="delay-load cartTable productTable" style="width:100%">
			              <thead>
			                <tr class="CartProduct cartTableHeader">
			                  <td style="width:15%">Product</td>
			                  <td style="width:45%">&nbsp;</td>
			                  <td style="width:10%">Credits</td>
			                  <td style="width:15%">Qty.</td>
			                  <td style="width:15%">Total</td>
			                </tr>              
			              </thead>
			              <tbody>
						    <?php if (count($cart) == 0) { ?>				              
				            <tr class="CartProduct">
					            <td colspan="5">Your shopping cart is empty.</td>
				            </tr>
				            <?php } else { ?>

								<?php
								$toggle = false;
								$i=0;
								foreach ($cart as $cartItem) {
									$toggle = !$toggle;
									
									$i++;

									?>

									<input type="hidden" name="cart_idProduct_<?php echo $i; ?>" value="<?php echo htmlentities($cartItem['idProduct']); ?>" />
									<input type="hidden" name="cart_Denomination_<?php echo $i; ?>" value="<?php echo htmlentities($cartItem['Denomination']); ?>" />
									
									<tr class="CartProduct">
										<td class="CartProductThumb">
											<div>
												<a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $cartItem['Product']->idProduct; ?>"><img
														src="<?php echo str_replace("http://", "https://", $cartItem['Product']->ImgPath); ?>"
														alt="<?php echo encode_text($cartItem['FullProductName']); ?>"></a>
											</div>
										</td>
										<td>
											<div class="CartDescription">

												<p><?php echo encode_text($cartItem['FullProductName']); ?></p>

												<span class="remove"><a
														href="<?php echo $storefront_url; ?>/deletefromcart/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $cartItem['idProduct']; ?>/<?php echo $cartItem['Denomination']; ?>">
														<i class="fa fa-times-circle"></i> Remove</a></span>
											</div>
										</td>
										<td><?php echo $redemption->DisplayAmount($cartItem['CreditCost']); ?></td>
										<td>
											<fieldset>
												<input class="quanitySniper" type="text"
													   value="<?php echo $cartItem['Quantity']; ?>" maxlength="2"
													   name="qty_<?php echo $i; ?>">
											</fieldset>
										</td>
										<td class="price"><?php echo $redemption->DisplayAmount($cartItem['CreditCost'] * $cartItem['Quantity']); ?></td>
									</tr>
								<?php }
							} ?>
			              </tbody>
			            </table>
		          	</div> <!--/ table-responsive -->
		          </div>
		          <!--cartContent-->
		          
		          <div class="cartFooter w100">
		            <div class="box-footer">
		              <div class="pull-left"> <a href="<?php echo $storefront_url; ?>/home/<?php echo $promoid; ?>/<?php echo $hash; ?>/" class="btn btn-default"> <i class="fa fa-arrow-left"></i> &nbsp; Continue shopping </a> </div>
		              <div class="pull-right">
		                <button type="submit" class="btn btn-default"> <i class="fa fa-undo"></i> &nbsp; Update cart </button>
		              </div>
		            </div>
		          </div> <!--/ cartFooter -->
		          
                  <?php if (strlen(trim($redemption->objSkin->CHECKOUT_FAQS_SMALL_HTML)) > 0) { ?>
		          <div class="cartFAQs w100 clearfix">
		          	<h3>Frequently Asked Questions</h3>
                    
		          	<ul class="list-unstyled">
                 	   <?php echo $redemption->objSkin->CHECKOUT_FAQS_SMALL_HTML; ?>
                       
                        <?php if (strlen(trim($redemption->objSkin->CHECKOUT_FAQS_THE_REST_HTML)) > 0) { ?>
                        <div class='faqs_the_rest' style='display: none;'>
							<?php echo $redemption->objSkin->CHECKOUT_FAQS_THE_REST_HTML; ?>
                        </div>
		          		<li>
		          			<p><a href="#" id='view_faqs'>View all FAQs</a></p>
		          		</li>
                        
                        <script>
							$(function() {
								$("#view_faqs").click(function() {
									$(".faqs_the_rest").slideToggle();	
									$("#view_faqs").toggle();
									return false;
							   });
						   });
						</script>
                        <?php } ?>
		          	</ul>
		          </div>
                  <?php } ?>
		          
		        </div>
		      </div>
		      <!--/row end--> 
		      
		    </div>
            
            </form>
            
		    <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
		      <div class="contentBox" >
		        <div class="w100 costDetails">
		          <div class="table-block" id="order-detail-content">
				<?php if (strlen($pin) == 0 || !$redemption->IsSignedIn || $total_points_in_cart > $credits) { ?>
					<a class="btn btn-primary btn-lg btn-block " title="checkout" href="javascript:document.forms.cart_pin_form.submit();" style="margin-bottom:20px"> Proceed to checkout &nbsp; <i class="fa fa-arrow-right"></i> </a>				
                <?php } else { ?>
			    	<a class="btn btn-primary btn-lg btn-block " title="checkout" href="<?php echo $storefront_url; ?>/checkout/<?php echo $promoid; ?>/<?php echo $hash; ?>/" style="margin-bottom:20px"> Proceed to checkout &nbsp; <i class="fa fa-arrow-right"></i> </a>	
                <?php } ?>			          
		            <div class="w100 cartMiniTable">
		              <table id="cart-summary" class="std table">
		                <tbody>
		                  <tr <?php if (!strlen($pin) == 0 || $redemption->IsSignedIn || !$total_points_in_cart > $credits) { ?>class="border-bottom"<?php } ?>>
		                    <td > Total </td>
		                    <td class=" site-color" id="total-price"><?php echo $redemption->DisplayAmount($total_points_in_cart); ?></td>
		                  </tr>
						  <?php if (strlen($pin) == 0 || !$redemption->IsSignedIn || $total_points_in_cart > $credits) { ?>		                  
		                  <tr>
		                    <td colspan="2"  ><div class="input-append couponForm">
                                                        
                            <form class="cart_pin_form" id='cart_pin_form' method='post' action="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>/">
                                 <input type='hidden' name='action' value='pin' />
								 <input type="text" name="PIN" class="col-lg-8 reward_code" value="<?php if (isset($_POST['PIN'])) echo htmlentities($_POST['PIN']); ?>"  placeholder="Reward code" />
								 <button class="col-lg-4 btn btn-success" type="submit" form="cart_pin_form">Apply!</button>
                            </form>			                    

		                    </td>
		                  </tr>
		                  <?php } ?>
		                </tbody>
		                <tbody>
		                </tbody>
		              </table>
		            </div>
		          </div>
		        </div>
		      </div>
		      <!-- End popular --> 
		      
		    </div>
		    <!--/rightSidebar--> 
		    
		  </div><!--/row-->
		  
		  <div style="clear:both"></div>
		</div><!-- /.main-container -->
	
	</div> <!-- /main-container-wrapper -->
	
	<?php include 'footer.php' ?>
	
	<?php include 'scripts.php' ?>

</div> <!-- /master-wrapper -->

</body>
</html>


