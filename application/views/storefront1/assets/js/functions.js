/*	Table OF Contents
	==========================
	Carousel
	Customs Script
	Custom Scrollbar
	Custom animated.css effect
	Equal height ( subcategory thumb)
	responsive fix
	*/
	

$(document).ready(function () {
	
    /*==================================
	Carousel
	====================================*/

    function random(owlSelector){
      owlSelector.children().sort(function(){
          return Math.round(Math.random()) - 0.5;
      }).each(function(){
        $(this).appendTo(owlSelector);
      });
    };
    
	function setHeight() {
		$(".owl-wrapper").css("min-height", function(){ 
		    return $(".owl-item").outerHeight();
		});	
	};
	
    // Carousel
    $(".owl-carousel-items").owlCarousel({
        navigation: true,
        pagination: false,
        navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        items: 4,
        itemsTablet: [768, 3],
        beforeInit : function(elem){
        	random(elem);
		},
		afterInit: function(){
			$(window).load(function(){
				setHeight();
			});
		},
		beforeUpdate: function(){
			setHeight();
		},	
		afterUpdate: function(){
			setHeight();
		},
		afterAction: function(){
			setHeight();
		}
    });
    
    // Carousel
    
    $(".owl-carousel-banners").owlCarousel({
        autoPlay: 5000, //Set AutoPlay to 3 seconds
        pagination: true,
		singleItem:true,
        theme: 'owl-banners'      
    });
   
    // YOU MAY ALSO LIKE  carousel

    $("#SimilarProductSlider").owlCarousel({
        navigation: true

    });


    /*==================================
	Customs Script
	====================================*/
	// Add fading to long titles in product 
	$('.item h4 a, .item h5').append( "<span class='fade-out'></span>");

    // collapse according add  active class
    $('.collapseWill').on('click', function (e) {
        $(this).toggleClass("pressed"); //you can list several class names 
        e.preventDefault();
    });

    $('.search-box .btn').on('click', function (e) {
        $('.search-full').addClass("active"); //you can list several class names 
        e.preventDefault();
    });
    $('.search-close').on('click', function (e) {
        $('.search-full').removeClass("active"); //you can list several class names 
        e.preventDefault();
    });

    // Customs tree menu script	
    $(".dropdown-tree-a").click(function () { //use a class, since your ID gets mangled
        $(this).parent('.dropdown-tree').toggleClass("open-tree active"); //add the class to the clicked element
    });

    $('.dropdown-treex').bind('click', function () {
        $(this).find('a:first-child').css('color', 'red');
    });

    // List view and Grid view 

    $('.display-list-view').click(function (e) { //use a class, since your ID gets mangled
        e.preventDefault();
        $('.item').removeClass('grid-view').addClass("list-view"); //add the class to the clicked element
    });

    $('.display-grid-view').click(function (e) { //use a class, since your ID gets mangled
        e.preventDefault();
        $('.item').removeClass("list-view").addClass("grid-view"); //add the class to the clicked element
    });
    
    if (/IEMobile/i.test(navigator.userAgent)) {
        // Detect windows phone//..
        $('.navbar-brand').addClass('windowsphone');
    }

    // top navbar IE & Mobile Device fix
    var isMobile = function () {
        //console.log("Navigator: " + navigator.userAgent);
        return /(iphone|ipod|ipad|android|blackberry|windows ce|palm|symbian)/i.test(navigator.userAgent);
    };

    if (isMobile()) {
        // For  mobile , ipad, tab
		 $('.introContent').addClass('ismobile');
		

    } else {


        $(function () {

            //Keep track of last scroll
            var tshopScroll = 0;
            $(window).scroll(function (event) {
                //Sets the current scroll position
                var ts = $(this).scrollTop();
                //Determines up-or-down scrolling
                if (ts > tshopScroll) {
                    // downward-scrolling
                    $('.navbar').addClass('stuck');

                } else {
                    // upward-scrolling
                    $('.navbar').removeClass('stuck');
                }

                if (ts < 600) {
                    // downward-scrolling
                    $('.navbar').removeClass('stuck');
                    //alert()
                }


                tshopScroll = ts;

                //Updates scroll position

            });
        });


    } // end Desktop else

    /*==================================
	 Custom Scrollbar for Dropdown Cart 
	====================================*/
	
    $(".scroll-pane").mCustomScrollbar({
        advanced: {
            updateOnContentResize: true

        },

        scrollButtons: {
            enable: false
        },

        mouseWheelPixels: "200",
        theme: "dark-2"

    });


    $(".smoothscroll").mCustomScrollbar({
        advanced: {
            updateOnContentResize: true

        },

        scrollButtons: {
            enable: false
        },

        mouseWheelPixels: "100",
        theme: "dark-2"

    });
  
        
    /*=====================================================
	 Remove item cart animation & don't show cart if empty
	======================================================*/    
    
	
	function getRowCount() {
		return $('.miniCartTable table tr').length;	
	};
	
	rowCount = getRowCount();
            
    $('.miniCartProduct .delete').click(function () {
    	
    	rowCount = getRowCount();
    		
    	if (rowCount > 1) {
			$(this).parent('tr').fadeOut(300, function() {
				$(this).remove();
				getRowCount();
			});
    	} else {
			$(this).parent('tr').fadeOut(300, function() {
				$(this).remove();
				$('.cartMenu').removeClass('hasItems');
				getRowCount();
			});
    	}
    });
    
    /*
    if (rowCount = 0) {
	    $('.cartMenu').removeClass('hasItems');
    };
    */


    /*=======================================================================================
	Code for equal height - // your div will never broken if text get overflow  
	========================================================================================*/

    $(function () {
        $('.thumbnail.equalheight').responsiveEqualHeightGrid(); // add class with selector class equalheight
    });



    /*=======================================================================================
	 Code for tablet device || responsive check
	========================================================================================*/


    if ($(window).width() < 989) {


        $('.collapseWill').trigger('click');

    } else {
        // ('More than 960');
    }


    $(".tbtn").click(function () {
        $(".themeControll").toggleClass("active");
    });
	

    /*==================================
	Global Plugin
	====================================*/

    // For stylish input check boX 

    $(function () {
        $(".ion-check").ionCheckRadio();

    });

    // bootstrap tooltip 
    $('.tooltipHere').tooltip();

    // customs select by minimalect
    $("#sortBy").minimalect({
	    placeholder: "Sort by..."
    });
    
    //$("select").minimalect();

    // cart quantity changer sniper
    $("input.quanitySniper").TouchSpin({
        buttondown_class: "btn btn-link",
        buttonup_class: "btn btn-link"
    });
	
    /*=======================================================================================
		end  
	========================================================================================*/

}); // end Ready

	$(window).load(function(){
		$('.delay-load').animate({opacity: 1});
			
	});