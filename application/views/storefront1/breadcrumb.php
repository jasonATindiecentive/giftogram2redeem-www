  <div class="row">
    <div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li <?php if ($thispage == "home") echo 'class="active"' ?>><a href="<?php echo $storefront_url; ?>/storefront/<?php echo $promoid . "/" . $hash; ?>">Home</a> </li>
        
          <?php if (isset($Crumbs)) foreach ($Crumbs as $Crumb) { ?>
            <li>
                <a href="<?php echo $storefront_url; ?>/results/<?php echo $promoid; ?>/<?php echo $hash; ?>/<?php echo $Crumb['idCategory']; ?>">
                    <?php echo htmlentities($Crumb['CategoryName']); ?>
                </a>
            </li>
          
          <?php } ?>
		
		<?php if ($thispage == 'detail') { ?>
			<li><?php echo encode_text($ProductDetail->ProductTitle);?></li>
		<?php } ?>
		
        
      </ul>
    </div>
  </div>  <!-- /.row  --> 