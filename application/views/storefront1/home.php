<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<?php include 'head.php'; ?>

<body>

<?php include 'enter_code.php' ?>

<?php include 'navigation.php' ?>

<div class="main-container-wrapper">

    <div class="container main-container headerOffset">

        <!-- Main component call to action -->

        <?php include 'breadcrumb.php' ?>

        <div class="row">

            <? include 'sidebar-nav.php' ?>

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
                        <?php if ($NewArrivals->numrows() > 0) { ?>
                            <li class="active"><a href="#new_arrivals" data-toggle="tab">New Arrivals</a></li>
                        <?php } ?>
                        <?php if ($StafFavorites->numrows() > 0) { ?>
                            <li><a href="#staff_favorites" data-toggle="tab">Staff Favorites</a></li>
                        <?php } ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="with-slider tab-content">

                        <?php $NewArrivals->ReWind();
                        if ($NewArrivals->numrows() > 0) {?>
                            <div class="tab-pane active" id="new_arrivals">
                                <div id="new_products_slider" class="owl-carousel owl-carousel-items owl-theme">
                                    <?php $MAX = 10; $i = 0;
                                    while ($Product = $NewArrivals->fetch()) {
                                        //if (strlen($Product['Title']) > $max_carousel_titlelen) continue; // skip long titles

                                        if (strlen($Product['Title']) > $max_carousel_titlelen) {
                                            $Product['Title'] = substr($Product['Title'], 0, $max_carousel_titlelen-5) . "...";
                                        }

                                        $i++;
                                        if ($i > $MAX) break; ?>
                                        <div class="item">
                                            <div class="product">
                                                <div class="image">
                                                    <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><img src="<?php echo $Product['MainImage']; ?>" alt="<?php encode_text($Product['Title']); ?>" class="img-responsive"/></a>
                                                </div>
                                                <div class="description">
                                                    <h4><a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><?php echo encode_text($Product['Title']); ?></a></h4>
                                                </div>
                                                <?php if ($Product['HasCreditRange']) { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product['MinCreditCost'], $Product['MaxCreditCost']); ?></span></div>
                                                    <div class="action-control"> <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
                                                <?php } else { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmount($Product['CreditCost']); ?></span></div>
                                                    <?php if ($Product['CreditCost'] > 0) { ?>
                                                        <div class="action-control"> <a href="cart.php?promoid=<?php echo $promoid; ?>&AddToCart=<?php echo $Product['ProductID']; ?>&CatType=<?php echo $Product['CatType']; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!--/new_products_slider-->
                            </div> <!--/#new_arrivals -->
                        <?php } ?>

                        <?php
                        $StafFavorites->ReWind();
                        if ($StafFavorites->numrows() > 0) {
                            $i = $StafFavorites->numrows();
                            ?>

                            <div class="tab-pane" id="staff_favorites">
                                <div id="staff_favorites_slider" class="owl-carousel owl-carousel-items owl-theme">

                                    <?php
                                    $k=0;
                                    $MAX = 10;
                                    for ($j = $i; $k < $MAX && $j >= 1; $j--) {
                                        $StafFavorites->seek($j-1);
                                        $Product = $StafFavorites->fetch();
                                        //if (strlen($Product['Title']) > $max_carousel_titlelen) continue; // skip long titles
                                        if (strlen($Product['Title']) > $max_carousel_titlelen) {
                                            $Product['Title'] = substr($Product['Title'], 0, $max_carousel_titlelen-5) . "...";
                                        }

                                        $k++;

                                        ?>
                                        <div class="item">
                                            <div class="product">
                                                <div class="image">
                                                    <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><img src="<?php echo $Product['MainImage']; ?>" alt="<?php encode_text($Product['Title']); ?>" class="img-responsive"/></a>
                                                </div>
                                                <div class="description">
                                                    <h4><a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><?php echo encode_text($Product['Title']); ?></a></h4>
                                                </div>
                                                <?php if ($Product['HasCreditRange']) { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product['MinCreditCost'], $Product['MaxCreditCost']); ?></span></div>
                                                    <div class="action-control"> <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
                                                <?php } else { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmount($Product['CreditCost']); ?></span></div>
                                                    <?php if ($Product['CreditCost'] > 0) { ?>
                                                        <div class="action-control"> <a href="cart.php?promoid=<?php echo $promoid; ?>&AddToCart=<?php echo $Product['ProductID']; ?>&CatType=<?php echo $Product['CatType']; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
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

                <?php $Popular->ReWind();
                if ($Popular->numrows() > 0) { ?>
                    <div class="delay-load product-tab w100 clearfix">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#popular_picks" data-toggle="tab">Popular Picks</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="with-slider tab-content">
                            <div class="tab-pane active" id="popular_picks">
                                <div id="popular_picks_slider" class="owl-carousel owl-carousel-items owl-theme">
                                    <?php $MAX = 12; $i = 0;
                                    while ($Product = $Popular->fetch()) {
                                        $i++;
                                        if (strlen($Product['Title']) > $max_carousel_titlelen) {
                                            $Product['Title'] = substr($Product['Title'], 0, $max_carousel_titlelen-5) . "...";
                                        }

                                        if ($i > $MAX) break; ?>
                                        <div class="item">
                                            <div class="product">
                                                <div class="image">
                                                    <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><img src="<?php echo $Product['MainImage']; ?>" alt="<?php encode_text($Product['Title']); ?>" class="img-responsive"/></a>
                                                </div>
                                                <div class="description">
                                                    <h4><a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><?php echo encode_text($Product['Title']); ?></a></h4>
                                                </div>
                                                <?php if ($Product['HasCreditRange']) { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product['MinCreditCost'], $Product['MaxCreditCost']); ?></span></div>
                                                    <div class="action-control"> <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
                                                <?php } else { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmount($Product['CreditCost']); ?></span></div>
                                                    <?php if ($Product['CreditCost'] > 0) { ?>
                                                        <div class="action-control"> <a href="cart.php?promoid=<?php echo $promoid; ?>&AddToCart=<?php echo $Product['ProductID']; ?>&CatType=<?php echo $Product['CatType']; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
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

                <?php  $TitlesYouMightLike->ReWind();
                if ($TitlesYouMightLike->numrows() > 0) { ?>

                    <div class="delay-load product-tab w100 clearfix">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#titles_liked" data-toggle="tab"><?php echo $redemption->objSkin->RANDOM_TITLES_TEXT; ?></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content row">
                            <div class="tab-pane active" id="titles_liked">
                                <div class="categoryProduct xsResponse clearfix">
                                    <?php $MAX = 12; $i = 0; while ($Product = $TitlesYouMightLike->fetch()) {
                                        //if (strlen($Product['Title']) > $max_carousel_titlelen) continue; // skip long titles
                                        $i++;
                                        if ($i > $MAX) break;
                                        if ($i % 5 == 0) $last = "last"; else $last = "";

                                        if (strlen($Product['Title']) > $max_carousel_titlelen) {
                                            $Product['Title'] = substr($Product['Title'], 0, $max_carousel_titlelen-5) . "...";
                                        }

                                        ?>
                                        <div class="item grid-view col-sm-4 col-lg-3 col-md-3 col-xs-12">
                                            <div class="product">
                                                <div class="image">
                                                    <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home">
                                                        <?php /*  <img src="../perfectimg/perfectimg.php/u=<?php echo urlencode($Product['MainImage']; ?>" alt="<?php encode_text($Product['Title']); ?>" class="img-responsive" width="<?php echo $Product['Real_W']; ?>" height="<?php echo $Product['Real_H']; ?>" />  */ ?>
                                                        <img src="<?php echo $Product['MainImage']; ?>" alt="<?php encode_text($Product['Title']); ?>" class="img-responsive" width="<?php echo $Product['Real_W']; ?>" height="<?php echo $Product['Real_H']; ?>" />
                                                    </a>
                                                </div>
                                                <div class="description">
                                                    <h4><a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home"><?php echo encode_text($Product['Title']); ?></a></h4>
                                                </div>
                                                <?php if ($Product['HasCreditRange']) { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmountRange($Product['MinCreditCost'], $Product['MaxCreditCost']); ?></span></div>
                                                    <div class="action-control"> <a href="detail.php?promoid=<?php echo $promoid; ?>&CatType=<?php echo $Product['CatType']; ?>&ProductID=<?php echo $Product['ProductID']; ?>&from=home" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Choose</span></a> </div>
                                                <?php } else { ?>
                                                    <div class="price"> <span><?php echo $redemption->DisplayAmount($Product['CreditCost']); ?></span></div>
                                                    <?php if ($Product['CreditCost'] > 0) { ?>
                                                        <div class="action-control"> <a href="cart.php?promoid=<?php echo $promoid; ?>&AddToCart=<?php echo $Product['ProductID']; ?>&CatType=<?php echo $Product['CatType']; ?>" class="btn btn-primary add_to_cart"> <span class="add2cart"><i class="fa fa-shopping-cart"></i>Add to Cart</span></a> </div>
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
