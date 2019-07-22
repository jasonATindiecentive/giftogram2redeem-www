<?php
$thispage="home";
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<?php include 'head.php';  ?>
  
<body>

<?php include 'enter_code.php';  ?>

<?php include 'navigation.php'; ?>

<div class="main-container-wrapper">

	<div class="container main-container headerOffset"> 
	  
	  <!-- Main component call to action -->
	  
	  <?php include 'breadcrumb.php';  ?>
	  
	  <div class="row">
	  
		<? include 'sidebar-nav.php'; ?>
	    
	    <!--right column-->
	    <div class="col-lg-9 col-md-9 col-sm-12">
	    
          <?php if (strlen(trim($redemption->objSkin->BANNER_OVERRIDE_HTML)) > 0 || 
				    strlen(trim($redemption->objSkin->BANNER_FOLDER)) > 0) { ?>
	      <div id="homeBanners" class="w100 category-top delay-load">
          	<?php if (strlen(trim($redemption->objSkin->BANNER_OVERRIDE_HTML)) > 0) { ?>
            	<?php echo $redemption->objSkin->BANNER_OVERRIDE_HTML; ?>
            <?php } else { ?>
            	<?php include "images/banners/{$redemption->objSkin->BANNER_FOLDER}/banners.php"; ?>
            <?php } ?>
            
	      </div><!--/.category-top-->
          <?php } ?>
	
	      <!-- NEW ARRIVALS & STAFF FAVORITES TAB -->
	
	      <div class="delay-load product-tab w100 clearfix">
	      
	        <ul class="nav nav-tabs">
		      <?php if ($NewArrivals->TotalProducts > 0) { ?>
	          <li class="active"><a href="#new_arrivals" data-toggle="tab">New Arrivals</a></li>
              <?php } ?>
	          <?php if ($RandomProducts->TotalProducts > 0) { ?>	          
	          <li><a href="#staff_favorites" data-toggle="tab">Staff Favorites</a></li>
              <?php }  ?>
	        </ul>
	        
	        <!-- Tab panes -->
	        <div class="with-slider tab-content">
		        
    	      <?php
			      if ($NewArrivals->TotalProducts > 0) {?>
	          <div class="tab-pane active" id="new_arrivals">
			  	<div id="new_products_slider" class="owl-carousel owl-carousel-items owl-theme">
			  	<?php $MAX = 10; $i = 0; 
			  	 	foreach ($NewArrivals->Products as $Product) {
			  	 		//if (strlen($Product->ProductTitle) > $max_carousel_titlelen) continue; // skip long titles
			  	 		
			  	 		if (strlen($Product->ProductTitle) > $max_carousel_titlelen) {
			  	 			$Product->ProductTitle = substr($Product->ProductTitle, 0, $max_carousel_titlelen-5) . "...";
			  	 		}
			  	 		
			  	 		$i++;
			  	 		if ($i > $MAX) break; ?>				  	
			  	   <div class="item">
			  	     <div class="product">
			  	       <div class="image">
			  	       	 <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>"><img src="<?php echo $Product->ImgPath; ?>" alt="<?php encode_text($Product->ProductTitle); ?>" class="img-responsive"/></a>
			  	       </div>
			  	       <div class="description">
			  	         <h4>
							 <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/">
								 <?php echo encode_text($Product->ProductTitle); ?>
							 </a>
						</h4>
			  	       </div>
			  		   <?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
				  	       <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product->DenominationMin, $Product->DenominationMax); ?></span></div>
				  	       <div class="action-control"> <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
			  		   <?php } else { ?>
				  	       <div class="price"> <span><?php echo $redemption->DisplayAmount($Product->DenominationMin); ?></span></div>
				  	       <?php if ($Product->DenominationMin == $Product->DenominationMax) { ?>
				  	       <div class="action-control"> <a href="<?php echo $storefront_url; ?>/cart<?php echo $promoid; ?>/?AddToCart=<?php echo $Product->idProduct; ?>>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
			  		       <?php } ?>
			  			<?php } ?>
			  	     </div>
			  	   </div>
			  	   <?php } ?>
				 </div>
			  	 <!--/new_products_slider-->           
	          </div> <!--/#new_arrivals -->
	          <?php }  ?>

    	      <?php

			  if ($RandomProducts->TotalProducts > 0) {
			   $i = $RandomProducts->TotalProducts;
			   ?>

	          <div class="tab-pane" id="staff_favorites">
			  	<div id="staff_favorites_slider" class="owl-carousel owl-carousel-items owl-theme">
				  	
			      <?php
				  $k=0;
				  $i=count($RandomProducts->Products);
				  $MAX = 10;
                  for ($j = $i; $k < $MAX && $j >= 1; $j--) {
				   
					  $Product = $RandomProducts->Products[$j-1];

					   if (strlen($Product->ProductTitle) > $max_carousel_titlelen) {
						$Product->ProductTitle = substr($Product->ProductTitle, 0, $max_carousel_titlelen-5) . "...";
					   }
				   
				   $k++;
				   
				   ?>				  	
			  	   <div class="item">
			  	     <div class="product">
			  	       <div class="image">
			  	       	 <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/"><img src="<?php echo $Product->ImgPath; ?>" alt="<?php encode_text($Product->ProductTitle); ?>" class="img-responsive"/></a>
			  	       </div>
			  	       <div class="description">
			  	         <h4><a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>"><?php echo encode_text($Product->ProductTitle); ?></a></h4>
			  	       </div>
						 <?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
							 <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product->DenominationMin, $Product->DenominationMax); ?></span></div>
							 <div class="action-control"> <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
						 <?php } else { ?>
							 <div class="price"> <span><?php echo $redemption->DisplayAmount($Product->DenominationMin); ?></span></div>
							 <?php if ($Product->DenominationMin == $Product->DenominationMax) { ?>
								 <div class="action-control"> <a href="<?php echo $storefront_url; ?>/cart<?php echo $promoid; ?>/?AddToCart=<?php echo $Product->idProduct; ?>>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
							 <?php } ?>
						 <?php } ?>
			  	     </div>
			  	   </div>
			  	   <?php } ?>
		  	   
			  	 </div>
			  	 <!--/staff_favorites_slider-->            
	          </div>
	          
	          <? } ?>
	        </div> <!-- /.tab content -->
	        
	      </div><!--/.product-tab-->
	      
			
	      <!-- POPULAR ITEMS PRODUCT TAB -->
	      
          
		  <?php	if ($PopularProducts->TotalProducts > 0) { ?>
	      <div class="delay-load product-tab w100 clearfix">
	      
	        <ul class="nav nav-tabs">
	          <li class="active"><a href="#popular_picks" data-toggle="tab">Popular Picks</a></li>
	        </ul>
	        
	        <!-- Tab panes -->
	        <div class="with-slider tab-content">
	          <div class="tab-pane active" id="popular_picks">
			  	<div id="popular_picks_slider" class="owl-carousel owl-carousel-items owl-theme">
                   <?php $MAX = 12; $i = 0;
				    foreach ($PopularProducts->Products as $Product) { 
				    	$i++;
				    	if (strlen($Product->ProductTitle) > $max_carousel_titlelen) {
				    		$Product->ProductTitle = substr($Product->ProductTitle, 0, $max_carousel_titlelen-5) . "...";
				    	}
				    	
				    	if ($i > $MAX) break; ?>				  	
			  	   <div class="item">
			  	     <div class="product">
						 <div class="image">
							 <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/"><img src="<?php echo $Product->ImgPath; ?>" alt="<?php encode_text($Product->ProductTitle); ?>" class="img-responsive"/></a>
						 </div>
						 <div class="description">
							 <h4><a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/"><?php echo encode_text($Product->ProductTitle); ?></a></h4>
						 </div>
						 <?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
							 <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product->DenominationMin, $Product->DenominationMax); ?></span></div>
							 <div class="action-control"> <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>&from=home" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
						 <?php } else { ?>
							 <div class="price"> <span><?php echo $redemption->DisplayAmount($Product->DenominationMin); ?></span></div>
							 <?php if ($Product->DenominationMin == $Product->DenominationMax) { ?>
								 <div class="action-control"> <a href="<?php echo $storefront_url; ?>/cart<?php echo $promoid; ?>/?AddToCart=<?php echo $Product->idProduct; ?>>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
							 <?php } ?>
						 <?php } ?>
			  	     </div>
			  	   </div>
			  	   <?php } ?>

			  	 </div>
			  	 <!--/new_products_slider-->           
	          </div> <!--/#popular_picks -->
	        </div> <!-- /.tab content -->
	        
	      </div><!--/.product-tab / Popular Items -->
	      <? } ?>

	      <!-- TITLES YOU MIGHT LIKE TAB -->
	      
	      <?php  
		   	if ($RandomProducts->TotalProducts > 0) { ?>
	      
	      <div class="delay-load product-tab w100 clearfix">
	      
	        <ul class="nav nav-tabs">
	          <li class="active"><a href="#titles_liked" data-toggle="tab"><?php echo $redemption->objSkin->RANDOM_TITLES_TEXT; ?></a></li>
	        </ul>
	        
	        <!-- Tab panes -->
	        <div class="tab-content row">
	          <div class="tab-pane active" id="titles_liked">
				<div class="categoryProduct xsResponse clearfix">
                	<?php $MAX = 12; $i = 0; foreach ($RandomProducts->Products as $Product) {
						$i++;
						if ($i > $MAX) break;
						if ($i % 5 == 0) $last = "last"; else $last = "";
						
						if (strlen($Product->ProductTitle) > $max_carousel_titlelen) {
							$Product->ProductTitle = substr($Product->ProductTitle, 0, $max_carousel_titlelen-5) . "...";
						}
						?>
					<div class="item grid-view col-sm-4 col-lg-3 col-md-3 col-xs-12">
			  	    	<div class="product">
							<div class="image">
								<a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/">
									<img src="<?php echo $Product->ImgPath; ?>" alt="<?php encode_text($Product->ProductTitle); ?>" class="img-responsive" />
								</a>
							</div>
				  	       <div class="description">
							   <h4>
								   <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/">
									   <?php echo encode_text($Product->ProductTitle); ?>
								   </a>
							   </h4>
				  	       </div>
							<?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
								<div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product->DenominationMin, $Product->DenominationMax); ?></span></div>
								<div class="action-control"> <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>&from=home" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
							<?php } else { ?>
								<div class="price"> <span><?php echo $redemption->DisplayAmount($Product->DenominationMin); ?></span></div>
								<?php if ($Product->DenominationMin == $Product->DenominationMax) { ?>
									<div class="action-control"> <a href="<?php echo $storefront_url; ?>/cart<?php echo $promoid; ?>/?AddToCart=<?php echo $Product->idProduct; ?>>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
								<?php } ?>
				  			<?php } ?>
			  	    	</div> <!-- /product-->
				  	</div><!--/.item-->
				  	<?php } ?>
				</div>			  
	          </div> <!--/#titles_liked -->
	        </div> <!-- /.tab content -->
	        
	      </div> <!--/.product-tab / Titles You Might Like -->
	      <?php } ?>
	    </div> <!--/right column end-->
 
	  </div> <!-- /.row  --> 
	</div> <!-- /main container -->
</div> <!-- /main container wrapper -->

<?php include 'footer.php' ?>

<?php include 'scripts.php' ?>

</body>
</html>
