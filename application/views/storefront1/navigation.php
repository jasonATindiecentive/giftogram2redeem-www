
<!-- Fixed navbar start -->
<div class="navbar navbar-tshop navbar-fixed-top megamenu" role="navigation">
  <div class="navbar-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
          <div class="pull-right">
            <ul class="userMenu">
              <?php if (strlen($pin) == 0 || !$redemption->IsSignedIn) { ?>
              <li><a href="#" data-toggle="modal" data-target="#enterCode"> <span class="">Enter Reward Code</span></a></li>
              <?php } if (strlen($pin) > 0 && $redemption->IsSignedIn) { ?>
			  
			  <? if(is_object($PinStatus) && $PinStatus->numOrders > 0) { ?>
                <li><a href='<?php echo $storefront_url; ?>/order-history'>View Order History</a></li>
                <?php if (!$credits > 0) { ?>
                <li><a href="#" data-toggle="modal" data-target="#enterCode">Enter a New Code</a></li>
                <? } ?>
              <? } ?>              
              
              <li class="hidden"><span class="">Reward Code: <?php echo strtoupper(trim($pin)); ?></span></li>
				  <?php //if ($credits > 0) { ?>
				  <?php if (strlen($pin) > 0) { ?>
	              <li><span style="padding-right: 10px;">You Have <?php echo  $redemption->DisplayAmount($credits); ?></span> <a href="#" data-toggle="modal" data-target="#enterCode">(Enter a New Code)</a></li>
	              <?php } ?>              
              <?php } ?>
              <li> <a href="<?php echo $redemption->objSkin->HelpLink; ?>" target="_blank"><span class="hidden-xs">Customer Support</span> <i class="fa fa-question-circle visible-xs "></i></a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!--/.navbar-top-->
  
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only"> Toggle navigation </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> </button>
      <a class="navbar-toggle" href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>">
          <i class="fa fa-shopping-cart" style="margin-right: 6px;"> </i>
          <span class="cartRespons">Cart <?php if (count($cart) > 0) { ?> (<?php echo count($cart) ?> Items)<?php } ?></span> </a>
      <a class="navbar-brand" href="<?php echo $storefront_url; ?>/home/<?php echo $promoid; ?>/<?php echo $hash; ?>">
      	<img src="<?php echo PL_ASSETS; ?>storefront1/<?php echo $redemption->objSkin->PRODUCT_LOGO_IMG; ?>" alt="<?php echo $redemption->objSkin->A_STORE_TITLE; ?>" />
      </a> 
      
      <!-- this part for mobile -->
      <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
        <div class="input-group">
          <button class="btn btn-nobg" type="button"> <i class="fa fa-search no-margin-right"> </i> </button>
        </div>
        <!-- /input-group --> 
        
      </div>
    </div>
        
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"> <a href="<?php echo $storefront_url; ?>/storefront/<?php echo $promoid; ?>/<?php echo $hash; ?>"> Home </a> </li>
        <!-- change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width -->
        <li class="dropdown megamenu-fullwidth "> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> CATEGORIES <b class="caret"> </b> </a>
          <ul class="dropdown-menu">
            <li class="megamenu-content"> 
              
              <!-- megamenu-content -->              
              <div class="col-lg-6 col-sm-6 col-md-6 ">
              	  <p><strong>Select a category</strong></p>
			  	  <?php if (is_array($Categories->Categories)) { ?>
			  	  <ul class="row unstyled noMarginLeft">
				  <?php $i = 1;
				  		$more_link = false;
				  
				  	foreach ($Categories->Categories as $Category) {
				  			$i++;
							if ($i > $redemption->objSkin->_MAX_TOP_CATEGORIES) break;
				  		?>
	                      	<li class="col-lg-4 col-xs-12">
	                      		<span>
	                      		<a <?php if ($idCategory == $Category->idCategory) echo " class='under' "; ?> href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Category->idCategory; ?>">
                                    <?php 
											if ($Category->CategoryName == strtoupper($Category->CategoryName))
												echo ucwords(strtolower($Category->CategoryName));
											else echo $Category->CategoryName;
									?>
                                    
                                 </a></span>
                              </li>
                              <?php if ($i == $redemption->objSkin->_MAX_TOP_CATEGORIES_MORE && count($Categories->Categories) > $i) { $more_link = true;?>
                             		<li class="col-lg-4 col-xs-12 more_li"><a href='#' id='show_more_top_categories'>More...</a></li>
                                    </ul>
			  						  <ul class="row unstyled noMarginLeft" style='display:none' id='more_top_categories'>
                                    <script>
										$(function() {
											$("#show_more_top_categories").click(function() {
												$(".more_li").toggle();
												$("#more_top_categories").slideToggle();
												return false;

											});
									   });
									</script>
				  			<?php }
				  		} ?>
                        

                        
                    <li class="col-lg-4 col-xs-12"><span><a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/0">View All Titles</a></span></li>
	              </ul>
	              <?php } ?>
              </div>
              	<?php $NewArrivalCount = 0;
			  	   	$max = 2;
					if (is_object($NewArrivals))
			  	   	foreach ($NewArrivals->Products as $Product) {
			  	   		$NewArrivalCount++;
			  	   		if ($NewArrivalCount > $max) break;
			  	   		
			  	   		$link = "detail/" . $promoid . "/" . htmlentities($Product->idProduct);
			  	   		
			  	   		?>	             
	              <ul class="col-lg-3  col-sm-3 col-md-3 col-xs-6">
	                <li class="no-margin productPopItem ">
                        <a href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>">
                            <img class="img-responsive" src="<?php echo $Product->ImgPath; ?>" alt="<?php echo encode_text($Product->ProductTitle); ?>">
                        </a>
                        <a class="text-center productInfo alpha90" href="<?php echo $storefront_url; ?>/detail/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Product->idProduct; ?>">
                            <?php echo encode_text($Product->ProductTitle); ?>
                        <br>
                          
                        <?php if ($Product->DenominationMin <> $Product->DenominationMax) { ?>
                          <span> <?php echo $redemption->DisplayAmountRange($Product->DenominationMin, $Product->DenominationMax); ?> </span>
                        <?php } else { ?>
                          <span> <?php echo $redemption->DisplayAmount($Product['Credits']); ?> </span>
                        <?php } ?>
                          </a>
	                  </li>
	              </ul>
              <?php } ?>
            </li>
          </ul>
        </li>
      </ul>
      
      <!--- this part will be hidden for mobile version -->
      <div class="nav navbar-nav navbar-right hidden-xs">
        <div class="dropdown cartMenu hasItems"> <a href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>" class="dropdown-toggle"> <i class="fa fa-shopping-cart"> </i> <span class="cartRespons"> My Cart <?php if (count($cart) > 0) { ?><span class="cartCredits">(<?php echo count($cart); ?> Items)</span> </span> <b class="caret"> </b><?php } ?></a>
        
		<?php if (count($cart) > 0) { ?>
          <div class="dropdown-menu col-lg-4 col-xs-12 col-md-4 ">
            <div class="w100 miniCartTable scroll-pane">
              <table class="productTable">
                <tbody>
	                
				<?php $toggle = false;
                      $total_points_in_cart = 0;
                      foreach ($cart as $cartItem) {
                        $toggle = !$toggle;
                          $total_points_in_cart += $cartItem['CreditCost'] * $cartItem['Quantity'];
                          
                          ?>
                  <tr class="miniCartProduct">
                    <td style="width:20%" class="miniCartProductThumb"><div> <img src="<?php echo str_replace("http://", "https://", $cartItem['Product']->ImgPath); ?>" alt="<?php echo encode_text($cartItem['FullProductName']); ?>"></div></td>
                    <td style="width:65%">
	                    <div class="miniCartDescription">
	                        <h4> <?php echo utf8_encode($cartItem['FullProductName']); ?> </h4>
	                        <div class="price"><span><?php echo $redemption->DisplayAmount($cartItem['CreditCost'] * $cartItem['Quantity']); ?></span></div>
                      </div>
                    </td>
                    <td  style="width:5%" class="delete"><a href="<?php echo $storefront_url; ?>/deletefromcart/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $cartItem['idProduct'];?>"> x </a></td>
                  </tr>
				  <?php } ?>
                </tbody>
              </table>
            </div>
            <!--/.miniCartTable-->
            
            <div class="miniCartFooter text-right">
              <h3 class="text-right subtotal">Total: <?php echo htmlentities($total_points_in_cart); ?> credit<?php if ($total_points_in_cart > 1) echo "s"; ?> </h3>
              <a href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>" class="btn btn-sm btn-danger"> <i class="fa fa-shopping-cart"> </i> VIEW CART </a>
                <a href="?php echo $storefront_url; ?>/delivery/<?php echo $promoid; ?>/<?php echo $hash; ?>" class="btn btn-sm btn-primary"> CHECKOUT </a> </div>
            <!--/.miniCartFooter--> 
            
          </div>
          <!--/.dropdown-menu-->
          <?php } ?>
        </div>
        <!--/.cartMenu-->
        
        <div class="search-box">
          <div class="input-group">
            <button class="btn btn-nobg" type="button"> <i class="fa fa-search no-margin-right"> </i> </button>
          </div>
          <!-- /input-group --> 
          
        </div>
        <!--/.search-box --> 
      </div>
      <!--/.navbar-nav hidden-xs--> 
    </div>
    <!--/.nav-collapse --> 
    
  </div>
  <!--/.container -->
  
  <div class="search-full text-right"> <a class="pull-right search-close"> <i class=" fa fa-times-circle"> </i> </a>
    <div class="searchInputBox pull-right">
	    <form id="searchform" method='post' action='<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/0/1/pop'>
			<input type="search" name="Search" placeholder="<?php echo $redemption->objSkin->SEARCH_FIELD_TEXT; ?>" value="<?php echo $Search; ?>" class="search-input">
			<button class="btn-nobg search-btn" type="submit" form="searchform"> <i class="fa fa-search no-margin-right"> </i> </button>
	    </form>
    </div>
  </div>
  <!--/.search-full--> 
  
</div>
<!-- /.Fixed navbar  -->
