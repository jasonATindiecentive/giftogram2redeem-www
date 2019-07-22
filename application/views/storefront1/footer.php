<footer>
  <div class="footer" id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-3  col-md-3 col-sm-4 col-xs-12">
          <h3><?php echo $redemption->objSkin->A_STORE_TITLE; ?></h3>
          <ul>
            <li class="supportLi">
              <p><?php echo $redemption->objSkin->FOOTER_TEXT; ?></p>
            </li>
            <li><a href="<?php echo $storefront_url; ?>/terms_conditions/<?php echo $promoid; ?>/<?php echo $hash; ?>">Terms & Conditions</a></li>
            <li><a href="<?php echo $storefront_url; ?>/privacy_policy/<?php echo $promoid; ?>/<?php echo $hash; ?>">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-lg-4  col-md-4 col-sm-4 col-xs-12">
          <h3>Browse <?php echo $redemption->objSkin->A_STORE_TITLE; ?></h3>
		  <?php if (is_array($Categories->Categories)) { ?>
          <ul class="row">
		  	<?php $MAX = 11; $i = 1;
		  		foreach ($Categories->Categories as $Category) {
		  				if (strlen($Category->CategoryName) > 20) continue;
		  				if ($i >= $MAX) break;
		  				
		  				$i++;
		  			?>
		  		<li class="col-lg-6 col-xs-12"><span><a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Category->idCategory; ?>"><?php echo $Category->CategoryName; ?></a></span></li>
		  	<?php } ?>
		  	<li class="col-lg-6 col-xs-12"><a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Category->idCategory; ?>"><span>View all titles</span></a></li>	          
          </ul>
          <?php } ?>
        </div>
        <div class="col-lg-2  col-md-2 col-sm-4 col-xs-12">
          <h3> Shopping Cart</h3>
          <ul>
            <li> <a href="<?php echo $storefront_url; ?>/cart/<?php echo $promoid; ?>/<?php echo $hash; ?>/"> View Cart</a> </li>
            <!--
            <li> <a href="checkout-1.php"> Checkout </a> </li>
            -->
          </ul>
        </div>
        <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
          <h3> Customer Service</h3>
          <ul>
            <li>
              <div class="input-append newsLatterBox text-center">
                <a class="btn" type="button" href="<?php echo $redemption->objSkin->HelpLink; ?>" target='_blank'> Help Desk <i class="fa fa-long-arrow-right"> </i> </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!--/.row--> 
    </div>
    <!--/.container--> 
  </div>
  <!--/.footer-->
  
  <div class="footer-bottom">
    <div class="container">
      <p class="pull-left"> &copy; <?php echo @date("Y"); ?> All right reserved.</p>
      <p class="pull-right">Powered by GfitoGram.</p>
    </div>
  </div>
  <!--/.footer-bottom--> 
</footer>