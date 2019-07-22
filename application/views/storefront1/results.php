<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<?php 
	$thispage="results";
	include 'head.php';
?>
  
<body>

<?php include 'enter_code.php' ?>

<?php include 'navigation.php' ?>

<div class="main-container-wrapper">

	<div class="container main-container headerOffset"> 
	    
	  <?php include 'breadcrumb.php' ?>    
	  
	  <div class="row">
	  
		<? include 'sidebar-nav.php' ?>
	    
	    <!--right column-->
	    <div class="col-lg-9 col-md-9 col-sm-12">
	    
	      <div class="w100 clearfix category-name">
		  <?php if (strlen($Search) > 0) { ?>		      
	        <h3>Showing results for: &quot;<?php echo $Search; ?>&quot;</h3>
	      <?php } else { ?>
           <h3>
		  	<?php if (is_array($Crumbs)) {
				$i=0;
          	    foreach ($Crumbs as $Crumb) { if (strlen($Crumb['CategoryName']) == 0) continue; ?>
                    <?php if ($i > 0) { ?>
                    <span class="accent">&raquo;</span> <!-- Display this <li> after every item except last -->
                    <?php } ?>
                    
                    <a href='<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Crumb['idCategory']; ?>'>
					
						<?php if ($Crumb['CategoryName'] == strtoupper($Crumb['CategoryName']))
												echo ucwords(strtolower($Crumb['CategoryName']));
												else echo $Crumb['CategoryName'];   ?>                      
                    </a>
          	    <?php $i++; }
          	} ?>
	        </h3>
	  <?php } ?>
		  
		  <?php if (count($subcategories) > 1  && strlen($Search) == 0) {
			  
			  // note: we don't deal with subcategories in this platform (yet)... this code may not work :)
			  ?>		  
		  
	        <h5>Try these sub-categories:</h5>
	        <ul class="list-inline sub-categories">
            <?php $i=0; $max=20; 
			 foreach ($subcategories as $subcat) { ?>
                    <li><a href='<?php echo $storefront_url; ?>/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $subcat['idCategory']; ?>/'>
						<?php if ($subcat['EnglishCategoryDesc'] == strtoupper($subcat['CategoryName']))
												echo ucwords(strtolower($subcat['CategoryName']));
												else echo $subcat['CategoryName'];   ?>                      
					</a></li>
                    
			 	<?php
			 	$i++;
			 	if ($i == $max) { ?>
                        <li id="showmorecats-li" style="border-right: 0px;"><a href='#' id='showmorecats'>More...</a></li>
                        <script language="javascript">
			 			$(document).ready(function($){
			 				$("#showmorecats").click(function() {
			 					$("#showmorecats-li").hide();
			 					$("#morecats").show();
			 				});
			 			});
			 		</script>
                        <span id='morecats' style="display: none;"> 		
                        						
			 	<?php }
            	 }
			  if ($i >= $max) { ?>
			 	 </span>
			  <?php } ?> 
	        </ul>		  
		  
		  <?php }
		  
		  	// end of sub-category code that may not work
		  ?>
		  
	      </div><!--/.category-top-->
	            
	      <div class="w100 productFilter clearfix">
	        <p class="pull-left">We found <strong><?php echo $total_results; ?></strong> items</p>
	        <div class="pull-right ">
	          <div class="change-order pull-right">
	            <select class="form-control" name="orderby" id="sortBy" placeholder="Sort by...">
	              <option value="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/1/title/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>" <?php if ($Sort == "title") echo " selected='selected'"?>>Sort by title</option>
	              <option value="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/1/new/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>" <?php if ($Sort == "new") echo " selected='selected'"?>>Sort by date added</option>
	              <option value="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/1/pop/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>" <?php if ($Sort == "pop") echo " selected='selected'"?>>Sort by popularity</option>
	            </select>	            
	          </div>
	          <div class="change-view pull-right"> 
	          <a href="#" title="Grid View" class="display-grid-view"> <i class="fa fa-th-large"></i> </a> 
	          <a href="#" title="List View" class="display-list-view "><i class="fa fa-th-list"></i></a> </div>
	        </div>
	      </div> <!--/.productFilter-->
	      <div class="delay-load row categoryProduct xsResponse clearfix">
    	  <?php foreach ($ProductResults->Products as $Product) {
		  	?>
		  	<div class="item grid-view col-sm-4 col-lg-3 col-md-3 col-xs-12">
		  	    <div class="product">
		  	    	<div class="image <?php echo "cat_" . $Product->ProductType; ?>">
		  	    	   <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/<?php echo $idCategory; ?>">
						   <img src="<?php echo $Product->ImgPath; ?>" alt="<?php echo encode_text($Product->ProductTitle); ?>" class="img-responsive">
					   </a>
		  	    	</div>
		  	    	<div class="description">
		  	    	  <h4><a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/<?php echo $idCategory; ?>">
		  			  <?php echo substr(encode_text($Product->ProductTitle), 0, 80);
                        if (strlen($Product->ProductTitle) > 80) {
                            echo "..."; ?>
                        <?php } ?>
		  	    	  </a></h4>

		  	    	   <p class="list-description"><?php echo substr(strip_tags(encode_text($Product->ProductDescription)), 0, 320);
					if (strlen($Product->ProductDescription) > 320) {
						echo "..."; ?>
						<a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/<?php echo $idCategory; ?>" class="under">more</a>
					<?php } ?></p>
		  	    	</div>

                    <?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
						<div class="price"><span><?php echo $redemption->DisplayAmountRange($Product->DenominationMin, $Product->DenominationMax); ?></span></div>
                    <?php } else { ?>
						<div class="price"><span><?php echo $redemption->DisplayAmount($Product->DenominationMin); ?></span></div>
                    <?php } ?>
                    
					<?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
					<div class="action-control">
						<a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>/<?php echo $idCategory; ?>" class="btn btn-primary add_to_cart">
							<span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span>
						</a>
					</div>                    
					<?php } else { ?>
					<div class="action-control">
						<a href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>" class="btn btn-primary add_to_cart">
							<span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span>
						</a>
					</div>                                        
					<?php } ?>
		  			<div class="clearfix"></div>
		  	    </div> <!-- /product-->
		  	</div><!--/.item-->
		  <?php } ?>

	      </div> <!--/.categoryProduct || product content end-->
	      
	       <div class="w100 categoryFooter">
	        <div class="pagination pull-left no-margin-top">
	          <ul class="pagination no-margin-top">
            <?php if ($Page > 1) { ?>
                <li class="arrow no_translate"><a href="<?php if ($Page > 1) { ?>
                    <?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/<?php echo $Page-1; ?>/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>
                <?php } ?>">«</a></li>
            <?php } ?>		          
            <?php
            
			$display_page_navs = 12;
			
			// big page numbers require less nav tabs because they won't fit
			if ($total_pages >= 100000) $display_page_navs -=5;
			else if ($total_pages >= 10000) $display_page_navs -=4;
			else if ($total_pages >= 1000) $display_page_navs -=3;
			else if ($total_pages >= 100) $display_page_navs -=1;
			
			
			if ($total_pages > $display_page_navs) {
			   $start = $Page - 7;
			   $max = $start + $display_page_navs;
			   if ($start < 1) {
			   	$start = 1;
			   	$max = $start + $display_page_navs;
			   }
			   if ($max > $total_pages) {
			   	$max = $total_pages;
			   	$start = $max - $display_page_navs;
			   }
			} else {
			   $max=$total_pages;
			   $start=1;
			}
			
			if ($start > 3) { ?>
                <li class="<?php if ($total_pagesi == $Page) echo "active"; ?>">
					<a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/1/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>">
						1
					</a>
				</li>
                </li>                        
				<?php } 		
				for ($i = $start; $i <= $max; $i++) { ?>
		    	<li class="<?php if ($i == $Page) echo "active"; ?>">
					<a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/<?php echo $i; ?>/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>">
						<?php echo $i; ?>
					</a>
				</li>
                <?php } ?>
                
                	
                <?php if ($Page < $total_pages && $total_pages < 15) { ?>
                <li><a href="<?php if ($Page <= $total_pages) { ?>
                    <?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/<?php echo $Page+1; ?>/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>
                <?php } ?>">»</a></li>
                <?php } ?>
                
                
                
                <?php if ($total_pages > 15 && $Page != $total_pages && $max < $total_pages) { ?>
                
                <li><span>...</span></li>
                <li class="<?php if ($total_pagesi == $Page) echo "active"; ?>">
					<a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/<?php echo $total_pages; ?>/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>">
						<?php echo $total_pages; ?>
					</a>
				</li>
                <?php } ?>
                
                <?php if ($total_pages > 15 && $Page != $total_pages) { ?>
                <li><a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $idCategory; ?>/<?php echo $Page+1; ?>/<?php if (strlen($Search) > 0) echo "?Search=" . urlencode($Search); ?>">»</a></li><?php } ?>
	          </ul>
	        </div>
	      </div> <!--/.categoryFooter-->
	    </div><!--/right column end-->
	  </div><!-- /.row  --> 
	</div> <!-- /main container -->
</div> <!-- /main container wrapper -->

<?php include 'footer.php' ?>

<?php include 'scripts.php' ?>

<script>
$(document).ready(function(){
    $('.change-order li').bind('click', function () { // bind change event to select
        var url = $(this).attr('data-value'); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });						
});
</script>

</body>
</html>
