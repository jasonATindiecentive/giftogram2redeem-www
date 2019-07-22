	<script type="text/javascript"> 
       $(document).ready(function($){
		   
		    <?php if (($showcodebox == '1' || $redemption->objSkin->PIN_NEEDPINTOBROWSE == "yes") && !$redemption->IsSignedIn) { ?>
				$('#enterCode').modal('show');
	       	<?php } ?>
	       		       
			// handle switch between where do i find reward code and pin entry
			$(".switchToggle").click(function() {
				$('.switch').toggleClass('hidden');
			});
			// reward code entry
			$("#pinsubmit").click(function() {

				$.get('/ajax/checkpin/<?php echo $promoid; ?>/<?php echo $hash; ?>/' + $("#pin").val(),
				  function(data) {
					  if (data.length > 0) {
						  alert(data);
					  } else {
						var url='<?php echo $storefront_url; ?>/registerpin/<?php echo $promoid; ?>/<?php echo $hash;?>/' +   $("#pin").val();
						  alert(url);
						  document.location = url;
					  }
				  });
			  });
			  $('[placeholder]').focus(function() {
			  	var input = $(this);
			  		if (input.val() == input.attr('placeholder')) {
			  			input.val('');
			  			input.removeClass('placeholder');
			  		}
			  	}).blur(function() {
			  	
			  	var input = $(this);
			  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
			  		input.addClass('placeholder');
			  		input.val(input.attr('placeholder'));
			  	}
			  	}).blur().parents('form').submit(function() {
			  		$(this).find('[placeholder]').each(function() {
			  		var input = $(this);
			  		if (input.val() == input.attr('placeholder')) {
			  			input.val('');
			  	}
			  	})
			  });				  
        });
    </script>

<!-- Code Entry modal -->
<div class="modal signUpContent fade" id="enterCode" tabindex="-1" role="dialog" data-show="true">
  <div class="modal-dialog ">
    <div class="modal-content">
	  <div id="reward_code" class="enter_code switch">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
	        <h3 class="modal-title-site text-center" > Enter Reward Code </h3>
	      </div>     <!-- /header --> 
	      <div class="modal-body">
	      	<p><?php echo htmlentities($redemption->objSkin->PIN_POPUP_WELCOME_TEXT); ?></p>
	        <?php if (isset($errmsg) && strlen($errmsg) > 0) { ?>
	      	<span class="error errmsg" id="errmsg"><?php echo htmlentities($errmsg); ?></span>
	        <?php } ?>
	        <form name="pin" id="thepinform" class="form-group login-username">
	          <div>
	            <input type="text" id="pin" class="form-control input"  size="20" placeholder="<?php echo $redemption->objSkin->PIN_3PINPlaceholderText; ?>" value="<?php //if (isset($pin)) echo htmlentities($pin); ?>">
	          </div>
	        </form>
	        <a name="pinsubmit" id="pinsubmit" class="btn btn-block btn-lg btn-primary" type="submit">SUBMIT</a>
	        <!--userForm-->        
	      </div> <!-- modal-body -->
	      <div class="modal-footer">
	        <p class="text-center">
	            <?php if ($redemption->objSkin->PIN_POPUP_WHERE_DO_I_FIND_POPUP == 'yes') { ?>
	            <a href="#" id="link_wheredoifindit" class="switchToggle body_color">
	            <?php } ?>
				<?php echo $redemption->objSkin->PIN_POPUP_WHERE_DO_I_FIND_TEXT; ?><!--Where do I find my reward code?-->
	            <?php if ($redemption->objSkin->PIN_POPUP_WHERE_DO_I_FIND_POPUP == 'yes') { ?>
	            <?php } ?>
	            </a>		        
	        </p>
	      </div>
      </div> <!-- /reward_code enter_code -->
	  <div id="wheredoifindit_section" class="hidden switch">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
	        <h3 class="modal-title-site text-center" > Instructions </h3>
	      </div>     <!-- /header --> 		  
		  <div class="modal-body">
          <?php echo $redemption->objSkin->HTML_WhereToFindCard; ?>
		  </div> <!-- /modal-body -->
	      <div class="modal-footer">
	        <p class="text-center"><a href='#' id="link_back" class="switchToggle">Enter my reward code</a></p>
	      </div>
	  </div>      
    </div>
    <!-- /.modal-content -->
    
  </div>
  <!-- /.modal-dialog --> 
  
</div>
<!-- /.Modal Code Entry --> 