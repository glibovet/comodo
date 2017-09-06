$(document).ready(function() {

	//SELECTED LANGUAGE
	$('.language a.active').click(function(e) { 
		e.preventDefault();
	});


	//MOBILE NAV
	$('.header__menu-btn').click(function(){
		if ($('.header__nav').hasClass('open-nav')) {
			$('.header__nav').removeClass('open-nav');
			$('.header').css('height','auto');
		} else {
			$('.header__nav').addClass('open-nav');
			$('.header').css('height','calc(100vh - 20px)');
		};
	});

	transformicons.add('.header__menu-btn');


	//OWL CAROUSEL
	$('.main-slider').owlCarousel({
		singleItem : true,
		pagination : true
	});

	$('.categories').owlCarousel({
		singleItem : true,
		pagination : false,
		navigation : true,
		navigationText : false
	});

	$('.news__action-slider').owlCarousel({
		singleItem : true,
		pagination : true
	});

	$('.viewed__carousel').owlCarousel({
		pagination : false,
		navigation : true,
		navigationText : false,
		items : 4,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [991, 2],
		itemsTablet : [768, 2],
		itemsMobile : [550, 1]
	});

	$('.card-info__photo-slider').owlCarousel({
		navigation : false,
		pagination : true,
		items : 3,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [991, 3],
		itemsTablet : [480, 2],
		itemsMobile : [320, 2]
	});


	$('.project-card__carousel').owlCarousel({
		navigation : false,
		pagination : true,
		items : 3,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [768, 2],
		itemsTablet : [480, 1],
		itemsMobile : [320, 1]
	});

	$('.news__new-article-slider').owlCarousel({
		singleItem : true,
		pagination : false,
		navigation : true,
		navigationText : false
	});

	//BIG PHOTO
	$('.card-info__photo-slide img').click(function(){
		var srcImg = $(this).attr('src');
		$('.card-info__big-photo').attr('src',srcImg);
	});


	//DROP DOWN LIST
	$('.header .drop-down').hover(function(){
		$(this).addClass('open-list');
	}, function(){
		$(this).removeClass('open-list');
	});

	$('.header__drop-down-list').hover(function(){
		$(this).prev().addClass('open-list');
	}, function(){
		$(this).prev().removeClass('open-list');
	});


	//TABS
	$('.similar__captions button').click(function(){
		$('.similar__captions button').removeClass('active');
		$(this).addClass('active');
		var tabName = '.' + $(this).attr('data-tabName');
		$('.similar__tab').css('display','none');
		$(tabName).css('display','block')
	});


	//NOREBOOK BANER
	 $(document).click(function(){
	 	var $hoverCartBtn = $('.header__cart');

	 	if ($hoverCartBtn.is(':hover') == false) {
	 		$('.header__notebook-baner').css('display','none');
	 	};
	 });

	$('.header__cart').click(function(){
		// e.preventDefault();
		$('.header__notebook-baner').css('display','block');
		if (($('.header__baner-inner').height()) > 305) {
			$('.header__baner-inner').css('height','305px');
				$('.header__baner-inner').jScrollPane({
				autoReinitialise : true
			});
		}
	});


	//PRODUCTS COUNT
	$('.count .plus').click(function(){
		var $input = $(this).parent().find('.value');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
	});
	$('.count .minus').click(function(){
        var $input = $(this).parent().find('.value');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
	});


	//THANKS YOU MODAL
	$('.thanks-you').remodal();


	//FILTER
	transformicons.add('.filter .filter__p-m');

	$('.filter__list').each(function(){
		if ($(this).height() > '162') {
			$(this).addClass('scroll');
			$(this).css('height','162px');
		};
	});

	$('.filter__list.scroll').jScrollPane({
		autoReinitialise : true
	});

	// $('.filter__caption').click(function(e){
	// 	if ($(this).parent().find('.filter__list').is(':visible') == false) {
	// 		$(this).parent().addClass('open');
	// 		$(this).parent().find('.filter__list').slideDown();
	// 		transformicons.transform('.filter.open .filter__p-m');
	// 	} else {
	// 		$(this).parent().find('.filter__list').slideUp();
	// 		$(this).parent().removeClass('open');
	// 		transformicons.revert('.filter .filter__p-m');
	// 		transformicons.transform('.filter.open .filter__p-m');
	// 	};
	// });

	$('.filter__caption').click(function(e){
		if ($(this).parent().find('.filter__list').is(':visible') == false) {
			$('.filter').removeClass('open');
			$(this).parent().addClass('open');
			$('.filter__list').slideUp();
			$(this).parent().find('.filter__list').slideDown();
			transformicons.revert('.filter .filter__p-m');
			transformicons.transform('.filter.open .filter__p-m');
		} else {
			$(this).parent().find('.filter__list').slideUp();
			transformicons.revert('.filter.open .filter__p-m');
			$(this).parent().removeClass('open');
		};
	});


	//CATALOG NEXT PAGE
	$('.catalog__next-page').click(function(){
		var pageNumber = Number($('.catalog__page-number').val()) + 1;
		$('.catalog__page-number').val(pageNumber);
	});


	//FACTORIES ALPHABET
	$('.alphabet__letter').click(function(){
		$('.alphabet__letter').removeClass('active');;
		$(this).addClass('active');
	});


	//VIDEO
	var video = document.getElementById("factories-more__video");

	$('.factories-more__video-btn').click(function(){
		video.play();
		$(this).css('display','none');
		$(video).css('cursor','pointer').attr('controls', ' ');
	});



	//VIEW ALL CATEGORIES
	$('.categories__item--all-categories').click(function(e){
		e.preventDefault();
		$('.categories__item').each(function(){
			var saveCategory = $(this).detach();
			saveCategory.appendTo('.all-categories');
		});
		$('.categories').remove();
	});	


	// $('.factories-more__more-btn').click(function(e){
	// 	e.preventDefault();
	// 	if ($(this).prev('.factories-more__text-wrap').hasClass('open')) {
	// 		$(this).prev('.factories-more__text-wrap').removeClass('open');
	// 		$(this).html('Читать далее');
	// 	} else {
	// 		$(this).prev('.factories-more__text-wrap').addClass('open');
	// 		$(this).html('скрыть');
	// 	}
	// });


	// //FACTORIES MORE VIEW ALL
	// $('.factories-more__card-more-btn').click(function(e){
	// 	e.preventDefault();
	// 	if ($(this).prev('ul').hasClass('open')) {
	// 		$(this).prev('ul').removeClass('open');
	// 		$(this).html('все');
	// 	} else {
	// 		$(this).prev('ul').addClass('open');
	// 		$(this).html('скрыть');
	// 	};
	// });


	//MASONRT FILTER
	$(function () {
    var self = $(".masonry");

    self.imagesLoaded(function () {
        self.masonry({
            gutterWidth: 15,
            isAnimated: true,
            itemSelector: ".similar__item"
        });
    });

  	$(".filter-btn").click(function(e) {
	    e.preventDefault();

	    var filter = $(this).attr("data-filter");
	        self.masonryFilter({
	            filter: function () {
	                if (!filter) return true;
	                return $(this).attr("data-filter") == filter;
	            }
	        });
	    });
	});
});