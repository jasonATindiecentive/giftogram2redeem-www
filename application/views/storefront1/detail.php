<?php
$thispage="detail";
include_once dirname(__FILE__) . "/../controller/handler.php";



?>
<!DOCTYPE html>


<?php include 'head.php'; ?>


<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

  
<body>

<?php include 'enter_code.php' ?>

<?php include 'navigation.php' ?>

<div class="main-container-wrapper">

	<div class="container main-container headerOffset">
	
	  <?php include 'breadcrumb.php' ?>    
	  
	  <div class="row">
	  
		<?php include 'sidebar-nav.php' ?>
	    
	    <!--right column-->
	    <div class="delay-load col-lg-9 col-md-9 col-sm-12">
	    
		    <!-- inside left column -->
		    <div class="col-lg-5 col-md-5 col-sm-5"> 
		      <!-- product Image and Zoom -->
		      
		      <div class="main-image col-lg-12 no-padding style3 product_image cat_<?php echo $ProductDetail->ProductType; ?>">
			      <img src="<?php echo $ProductDetail->ImgPath; ?>" alt="<?php echo $ProductDetail->ImgPath; ?>" class="img-responsive">
			  </div>
		      <div class="clearfix"></div>
		    </div>
		    <!--/ inside left column end --> 
		    
		    <!-- inside right column -->
		    <div class="col-lg-7 col-md-7 col-sm-7">
		      <h1 class="product-title"><?php echo encode_text($ProductDetail->ProductTitle);?></h1>
		      
			  <?php if ($ProductDetail->DenominationMin <> $ProductDetail->DenominationMax) { ?>
		      	<div class="product-price"> <span class="price-sales"><?php echo $redemption->DisplayAmountRange($ProductDetail->DenominationMin, $ProductDetail->DenominationMax); ?></span></div>
			  <?php } else { ?>
			  <?php if($ProductDetail->DenominationMin > 0) { ?>
		      	<div class="product-price"> <span class="price-sales"><?php echo $redemption->DisplayAmount($ProductDetail->DenominationMin); ?></span></div>
			  <?php } else { ?> 

			  <?php } ?>
			  <?php } ?>
		     		     
		      <div class="details-description">
              	<?php
                	$all_words = explode(" ", encode_text(str_replace("\n", "<br/>", $ProductDetail->ProductDescription)));
					$i =0;
					$has_more = false;
					
					?>
                    <p>
                    
                    <?php foreach ($all_words as $word) {
						if ($i == $redemption->objSkin->MAX_DESCRIPTION_LEN_BEFORE_MORE && $redemption->objSkin->MAX_DESCRIPTION_LEN_BEFORE_MORE > 0) { $has_more = true; ?>
                            
                            <script>
								$(function() {
									$("#detail_show_more").click(function() {
										$("#detail_more").slideToggle();
										$("#detail_show_more").hide();
										return false;

									});
							   });
							</script>
							<span style='display:none;' id="detail_more">
						<?php }
						
						?>
                    	<?php echo $word . " "; ?>
                    <?php
                    $i++;
					} ?>
                    
                    <?php if ($has_more) { ?>
                    	</span>
                       	<a href="#" id='detail_show_more'>Show More...</a>
					<?php } ?>
					
                </p>
		      </div>
              <?php if ($ProductDetail->DenominationMin <> $ProductDetail->DenominationMax) { ?>
		      <div class="productFilter">
		        <div class="filterBox">				  

			  	<select name='Denomination' id='Denomination'>
			  		<option value=''><?php echo $redemption->objSkin->SelectAnOptionTEXT; ?></option>
                      <?php


					  if ($ProductDetail->DenominationMode == "specific") {
						  foreach ($ProductDetail->Denominations as $Denomination) {

							  // skip anything less than the minimum
							  if ($Denomination < $MinDenomination) continue;
							  // skip anything more than the maximum
							  if ($Denomination > $MaxDenomination) continue;
							  
							  // skip anything that is not increments of StepDenomination
							  if ($Denomination % $StepDenomination != 0) continue;
							  ?>
							  <option
								  value='<?php echo $Denomination; ?>'><?php echo str_replace("_AMT_", $Denomination, $ProductDetail->ProductTitleWithAmount); ?></option>
						  <?php }
					  } else {
						for ($i = ceil($ProductDetail->DenominationMin / $StepDenomination) * $StepDenomination; $i <= $ProductDetail->DenominationMax; $i += $StepDenomination) {
							if ($i < $MinDenomination) continue;
					  ?>
						  <option
							  value='<?php echo $i; ?>'><?php echo str_replace("_AMT_", $i, $ProductDetail->ProductTitleWithAmount); ?></option>
					  <?php } ?>
					<?php } ?>
			  	</select>
		        </div>
		      </div>
		      <!-- productFilter -->              
              <?php } ?>		      
		      	      
			  <?php if ($ProductDetail->DenominationMin > 0) { ?>
		      <div class="cart-actions">
		        <div class="addto">			  
			   <?php if ($ProductDetail->DenominationMin <> $ProductDetail->DenominationMax) { ?>
                      <a id='add_to_cart' href="#" class="button btn-cart cart first" title="Add to Cart" type="button">Add to Cart</a>
                      <script>
			   	$(document).ready(function() {
			   		$("#add_to_cart").click(function() {
						
						var url = '<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idProduct; ?>/' + $("#Denomination").val(); 
						
			   			if ($("#Denomination").val() == '') {
			   				alert("<?php echo htmlentities($redemption->objSkin->SelectAnOptionERRORTEXT); ?>");
			   			} else {
							window.location = url;
			   			}
						return false;
			   	   	});
			      });
			   		</script>
                  <?php } else { ?>
                      <a id='add_to_cart' href="<?php echo $storefront_url; ?>/addtocart/<?php echo $idCampaign; ?>/<?php echo $hash; ?>/<?php echo $ProductDetail->idProduct; ?>" class="button btn-cart cart first" title="Add to Cart" type="button">Add to Cart</a>
                  <?php } ?>
		        </div>
		        <div style="clear:both"></div>
		        <h3 class="incaps"><i class="fa fa-check-circle-o color-in"></i> In stock</h3>
		        
                
				<?php if (isset($ProductDetail->HasMobile) && $ProductDetail->HasMobile == 'yes') { ?>		      
                    <h3 class="incaps"> <i class="fa fa-mobile"></i> Redeemable via Mobile</h3>
                <?php } else if (isset($ProductDetail->HasMobile) && $ProductDetail->HasMobile == 'no') { ?>	
                    <h3 class="incaps"> <i class="fa fa-print"></i> Requires Printer</h3>
                <?php } else { ?>
                
					<?php if (isset($ProductDetail->HasPrinter) && $ProductDetail->HasPrinter == 'yes') { ?>		      
                    <h3 class="incaps"> <i class="fa fa-mobile"></i> Requires Printer</h3>
                    <?php } else { ?>  
                            
                        <?php if (isset($ProductDetail->AddToCartText) && strlen($ProductDetail->AddToCartText) > 0) { ?>		        
                            <h3 class="incaps"> <i class="fa fa-building-o"></i> <?php echo encode_text($ProductDetail->AddToCartText); ?></h3>
                        <?php } ?>      
                        
					<?php } ?>                    
                
                <?php } ?>
                
		      </div>
		      <!--/.cart-actions-->                  
               <?php } ?>
		      
		      <div class="clearfix"></div>
		       
            <?php /*
 
 				unused - leaving for now in case it's useful in the future
 
				if (is_array($ProductDetail['ProductDetails']) && count($ProductDetail['ProductDetails']) > 0) {
				foreach ($ProductDetail['ProductDetails'] as $Detail) {
				?>		       
		       
	          <div class="product-details" id="details">
	          	  <h4><?php echo $Detail['Name']; ?></h4>
				  <ul>
                	<?php foreach ($Detail['Items'] as $item) { ?> 
						<li><span><?php echo $item; ?></span></li>
					<?php } ?>
				</ul>          
	          </div>
	          <?php } } ?>
	
		      <div class="clearfix"></div>
 
 				*/ ?>
		      
		    </div><!--/inside right column top end-->
			
			<div class="col-lg-12">
				<div class="product-tab w100 clearfix">
				    <ul class="nav nav-tabs">
					 <?php if (is_array($ProductDetail->SimiliarProducts) && count($ProductDetail->SimiliarProducts) > 0) { ?>
					      <li class="active"><a href="#more_category"  data-toggle="tab">More In This Category</a></li>
					 <?php } ?>
					 <?php if (is_array($recenthistory) && count($recenthistory) > 0) { ?>
				          <li><a href="#recently_viewed" data-toggle="tab">Recently Viewed</a></li>
                     <?php } ?>					 
				    </ul>
				    
				    <!-- Tab panes -->
				    <div class="with-slider tab-content">
					    
                      <?php if (is_array($ProductDetail->SimiliarProducts) && count($ProductDetail->SimiliarProducts) > 0) { ?>
				      <div class="tab-pane active" id="more_category">
				      	<div id="new_products_slider" class="owl-carousel owl-carousel-items owl-theme">
						   <?php foreach ($ProductDetail->SimiliarProducts as $AnotherProduct) {

						   if (strlen($AnotherProduct->ProductTitle) > $max_carousel_titlelen) continue; // skip long titles
						   if (strlen($AnotherProduct->ProductTitle) == 0) continue; // skip long titles
						   	?>				      	   
				      	   
				      	   <div class="item">
				      	     <div class="product">
				      	       <div class="image">
				      	       	 <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>/<?php echo $idCategory; ?>"><img src="<?php echo $AnotherProduct->ImgPath; ?>" alt="<?php echo encode_text($Product->ProductTitle); ?>" class="img-responsive"></a>
				      	       </div>
				      	       <div class="description">
				      	         <h4><a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>/<?php echo $idCategory; ?>"><?php echo encode_text($AnotherProduct->ProductTitle); ?></a></h4>
				      	       </div>
						       <?php if ($AnotherProduct->DenominationMin <> $AnotherProduct->DenominationMax) { ?>
							   <div class="price"> <span><?php echo $redemption->DisplayAmountRange($AnotherProduct->DenominationMin, $AnotherProduct->DenominationMax); ?></span></div>
							   <div class="action-control"> <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>/<?php echo $idCategory; ?>" class="btn btn-primary"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>							   		       
                               <?php } else { ?>
							   <div class="price"> <span><?php echo $redemption->DisplayAmount($AnotherProduct->DenominationMin); ?></span></div>			   
							   <div class="action-control"> <a href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
                               <?php } ?>				      	       
				      	     </div>
				      	   </div>
				      	   <?php } ?>				      	   		  	   
				      	 </div>
				      	 <!--/new_products_slider-->           
				      </div> <!--/#more_category -->
				      <?php } ?>
				      
                      <?php if (is_array($recenthistory) && count($recenthistory) > 0) { ?>
				      <div class="tab-pane" id="recently_viewed">
				      	<div id="staff_favorites_slider" class="owl-carousel owl-carousel-items owl-theme">
                        <?php foreach ($recenthistory as $AnotherProduct) {
						 	if (strlen($AnotherProduct->ProductTitle) > $max_carousel_titlelen) {
						 		$AnotherProduct->ProductTitle = substr($AnotherProduct->ProductTitle, 0, $max_carousel_titlelen-5) . "...";
						 	}
						 	?>
							<div class="item">
								<div class="product">
									<div class="image">
										<a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>/<?php echo $idCategory; ?>"><img src="<?php echo $AnotherProduct->ImgPath; ?>" alt="<?php echo encode_text($Product->ProductTitle); ?>" class="img-responsive"></a>
									</div>
									<div class="description">
										<h4><a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>/<?php echo $idCategory; ?>"><?php echo encode_text($AnotherProduct->ProductTitle); ?></a></h4>
									</div>
									<?php if ($AnotherProduct->DenominationMin <> $AnotherProduct->DenominationMax) { ?>
										<div class="price"> <span><?php echo $redemption->DisplayAmountRange($AnotherProduct->DenominationMin, $AnotherProduct->DenominationMax); ?></span></div>
										<div class="action-control"> <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>/<?php echo $idCategory; ?>" class="btn btn-primary"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
									<?php } else { ?>
										<div class="price"> <span><?php echo $redemption->DisplayAmount($AnotherProduct->DenominationMin); ?></span></div>
										<div class="action-control"> <a href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $AnotherProduct->idProduct; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
									<?php } ?>
								</div>
							</div>
				      	   <?php } ?>		  	   
				      	 </div>
				      	 <!--/staff_favorites_slider-->            
				      </div>
				    <?php } ?>
				    </div> <!-- /.tab content -->
				</div> <!-- / product-tab -->
			</div> <!-- Recently Viewed / You Might Like -->
		    
		  </div> <!--/ right column end --> 
		  
	    </div> <!--/.row-->
	
	  </div><!-- /.row  -->   
	  
	</div> <!-- /main-container -->

</div> <!-- /main container wrapper -->

<?php include 'footer.php' ?>

<?php include 'scripts.php' ?>
</body>
</html>
