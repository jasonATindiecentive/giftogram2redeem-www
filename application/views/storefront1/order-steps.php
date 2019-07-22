            <ul class="orderStep ">
	    			<?php if ($product_type == 'physical') {?><li class="<?php if ($thispage == 'delivery') { ?>active<?php } else {?>disabled<?php } ?>"><a href="#"><span class="step"><i>1</i>Your Info</span></a></li><?php }?>
	    			<?php if ($product_type == 'email') {?><li class="<?php if ($thispage == 'confirm') { ?>active<?php } else {?>disabled<?php } ?>"><a href="#"><span class="step"><i>1</i>Your Info</span></a></li><?php }?>
	    			<?php if ($product_type == 'download') {?><li class="<?php if ($thispage == 'orderhistory') { ?>active<?php } else {?>disabled<?php } ?>"><a href="#"><span class="step"><i>1</i>Your Info</span></a></li><?php }?>
	    			<li class="<?php if ($thispage == 'confirm') { ?>active<?php } else {?>disabled<?php } ?>"><a href="#"><span class="step"><i>2</i>Review Info</span></a></li>
	    			<?php if ($product_type == 'physical' || $product_type == 'email') {?><li class="<?php if ($thispage == 'orderhistory') { ?>active<?php } else {?>disabled<?php } ?>"><a href="#"><span class="step"><i>3</i>Checkout</span></a></li><?php }?>
	    			<?php if ($product_type == 'download') {?><li class="<?php if ($thispage == 'orderhistory') { ?>active<?php } else {?>disabled<?php } ?>"><a href="#"><span class="step"><i>3</i>Download</span></a></li><?php }?>	            
            </ul>
            <!--/.orderStep end-->

			<?php if (strlen($infomsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
				    <div class="error warning mt15">
				    	<?php echo $infomsg; ?>
				    </div>
				</div>
			</div>
		    <?php } ?>
            
            <?php if (strlen($errmsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
				    <div class="error mt15">
				    	<?php echo $errmsg; ?>
				    </div>
				</div>
			</div>            
		    <?php } ?>
            
            <?php if (strlen($successmsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
				    <div class="error success mt15">
				    	<?php echo $successmsg; ?>
				    </div>
				</div>
			</div>
		    <?php } ?>
            
            <?php if (strlen($attentionmsg) > 0) { ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="error mt15">
						<?php echo $attentionmsg; ?>
					</div>
				</div>
			</div>            
		    <?php } ?>
		                