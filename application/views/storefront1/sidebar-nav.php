   <!--left column-->
  
    <div id="sidebar" class="col-lg-3 col-md-3 col-sm-12">
      <div class="panel-group" id="accordionNo">
       <!--Category--> 
        <div class="panel panel-default delay-load">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            Category 
            </h4>
          </div>
          
          <div id="collapseCategory" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked tree">
                <?php if (count($PopularCategories->Categories) > 0) { ?>
                <li id="popItems" class="active dropdown-tree open-tree">
                    <a class="dropdown-tree-a" > <span class="badge pull-right">
                            <?php echo min($redemption->objSkin->MAX_POPULAR_CATEGORIES, count($PopularCategories->Categories)); ?>
                        </span> POPULAR CATEGORIES
                    </a>
                  <ul class="category-level-2 dropdown-menu-tree">
				  <?php                 
				  $MAX = $redemption->objSkin->MAX_POPULAR_CATEGORIES; $i = 0;
                  foreach ($PopularCategories->Categories as $Category) {
				  	$i++;
				  	if ($i > $MAX) break;
				  	?>
                    	<li>
                    	    <a <?php if ($idCategory == $Category->idCategory) echo " class='under' "; ?> href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Category->idCategory; ?>">
                    	    <?php 
											if ($Category->CategoryName == strtoupper($Category->CategoryName))
												echo ucwords(strtolower($Category->CategoryName));
												else echo $Category->CategoryName; ?>
                    	    </a>
                    	</li>
				  <?php } // end foreach major categories ?>
                  </ul>
                </li>
                <?php } ?>
                  
                

                <?php if (count($Categories->Categories) > 0) { ?>
                    <li class="active dropdown-tree">
                        <a class="dropdown-tree-a" >
                            <span class="badge pull-right">
                                <?php echo min($redemption->objSkin->_MAX_LEFT_CATEGORIES, count($Categories->Categories)); ?>
                            </span> 
                            <?php echo $redemption->objSkin->ALL_TITLES_TEXT; ?>
                        </a>
                        <ul class="category-level-2 dropdown-menu-tree">
                            <?php $i = 1;


                            foreach ($Categories->Categories as $Category) {
                                $i++;
                                ?>
                                <li>
                                    <a <?php if ($idCategory == $Category->idCategory) echo " class='under' "; ?> href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Category->idCategory; ?>">
                                        <?php
                                        if ($Category->CategoryName == strtoupper($Category->CategoryName))
                                            echo ucwords(strtolower($Category->CategoryName));
                                        else echo $Category->CategoryName; ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <li><a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/0"> <?php echo $redemption->objSkin->ALL_TITLES_TEXT2; ?></a></li>
                        </ul>
                    </li>
                <?php } // end if has subcategories ?>

                
            </div>
          </div>
        </div> <!--/Category menu end-->
        
  	    <?php  if (count ($NewArrivals->Products) > 0) { ?>
        <!--New Arrivals--> 
        <div id="new_arrivals_sidebar" class="panel panel-default delay-load">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            New Arrivals
            </h4>
          </div>
          
          <div id="collapseCategory" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav row image-sidebar">
              	<?php $NewArrivalCount = 0;
			  	   	$max = 4;
			  	   	foreach ($NewArrivals->Products as $Product) {
			  	   		$NewArrivalCount++;
			  	   		if ($NewArrivalCount > $max) break;
			  	   		
			  	   		$link = $storefront_url . "/detail/{$promoid}/{$hash}/{$Product->idProduct}/?from=home";
			  	   		
			  	   		?>	              
			  	 <li class="col-lg-12 col-md-12 col-sm-3">
                	<div class="item-container">
	                	<a href="<?php echo $link; ?>"><img class='cat_<?php echo $Product->ProductType; ?>' src="<?php echo $Product->ImgPath; ?>" alt="<?php echo encode_text($Product->ProductTitle); ?>" width="75"/></a>
	                	<div class="copy">
	                		<a href="<?php echo $link; ?>"><h5><?php echo encode_text($Product->ProductTitle); ?></h5></a>
							<p><?php echo encode_text(strip_tags(substr($Product->ProductDescription, 0, 50)));
                                     if (strlen($Product->ProductDescription) > 50) echo "..."; ?></p>
	                	</div>
                	</div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div> <!--/New Arrivals menu end-->
        <?php } ?>  
      </div>
    </div>
