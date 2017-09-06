var RS = "/";

$(document).ready(function(){
	
	$(".phone_number").inputmask({"mask": "+38(099)999-99-99"});
	//$(".payment_card").inputmask({"mask": "9999-9999-9999-9999"});
	//assert.equal(testmask.inputmask._valueGet(), "____-____-____-____", "Result " + testmask.inputmask._valueGet());
});


// ga BUTTONS 
$('.send-request-btn').click(function(){
		console.log (1);
		ga('send','event','request','open_request');
	});		

$('.header__request-call').click(function(){
		console.log (3);
		ga('send','event','call_request','open_request');
	});	

$('.footer__request-call').click(function(){
		console.log (3);
		ga('send','event','call_request','open_request');
	});	

$('.footer__subscribe').click(function(){
		console.log (6);
		ga('send','event','subscribe','open_request');
	});

$('.fb').click(function(){
		console.log (8);
		ga('send','event','facebook','follow');
	});

$('.insta').click(function(){
		console.log (8);
		ga('send','event','instagram','follow');
	});
			
	
	
// AND ga BUTTONS

// TABS 
$('.tab-button').click(function(){
		var tabContent = '#' + $(this).closest('.tabs').attr('id') + ' .tab-content';
		var tabButton = '#' + $(this).closest('.tabs').attr('id') + ' .tab-button';
		$(tabContent).removeClass('active');
		$(tabButton).removeClass('active');
		$(this).addClass('active');
		var tabId = '#' + $(this).attr('data-tab');
		$(tabId).addClass('active');
	});	
// /TABS


$('#showCommForm').click(function(){
		$('#showCommForm').css('display', 'none');
		$('#artCommForm').toggle(200);
});

$('#showProdForm').click(function(){
		$('#showProdForm').css('display', 'none');
		$('#prodCommForm').toggle(200);
});

//COLLECTIONS VIEW ALL
	$('.similar__view-all.open').click(function(e){
		e.preventDefault();
		$(this).removeClass('active');
		$(this).parent().find('.similar__view-all.close').addClass('active');
		
		$(this).parent().find('div.row').addClass('open');
	});

//COLLECTIONS HIDE
	$('.similar__view-all.close').click(function(e){
		e.preventDefault();
		$(this).removeClass('active');
		$(this).parent().find('.similar__view-all.open').addClass('active');
			
		$(this).parent().find('div.row').removeClass('open');
	});
	
	//HIDE CONT VIEW ALL
	$('.show_hide_cont').click(function(e){
		e.preventDefault();
		$(this).removeClass('active');
		
		$(this).parent().find('.hide_hide_cont').addClass('active');	
		$(this).parent().find('.hide_cont').addClass('open');
		
		$(this).parent('.hide_hide_cont').addClass('active');		
		$(this).parent('.hide_cont').addClass('open');
	});

	//HIDE CONT HIDE
	$('.hide_hide_cont').click(function(e){
		e.preventDefault();
		$(this).removeClass('active');
		
		$(this).parent().find('.show_hide_cont').addClass('active');		
		$(this).parent().find('.hide_cont').removeClass('open');
		
		$(this).parent('.show_hide_cont').addClass('active');		
		$(this).parent('.hide_cont').removeClass('open');
	});
	
// PRICE SLIDER	
	/*
	
								
	
	jQuery("#Slider2").ionRangeSlider({
                    type: "double",
                    postfix: " "+$.fn.currency,
                    step: 1,
					from: $.fn.filter_price_min, 
					to: $.fn.filter_price_max, 
					min:$.fn.filter_price_left,
					max:$.fn.filter_price_right,
					dimension: '' ,
                        onFinish: function(obj){
										
										jQuery("#priceMin").val( obj.from );
										jQuery("#priceMax").val( obj.to );
										
										jQuery("#price_inner_sl_1").val( obj.from );
										jQuery("#price_inner_sl_2").val( obj.to );
										
										$.post("/ajax/",$('#catFilter').serialize(),function(data,status){
												if(status=='success')
												{
													if(data.status=='success')
													{
														document.location.reload();
													}else{
														console.log(data.message);
														}
												}
											},"json");
                    }
                });
				
			var slider = $("#Slider2").data("ionRangeSlider");	
				
			$('#price_inner_sl_1').bind('change', function(){
				var value = $(this).val();
			
				slider.update({
					from: value
				});
				
				jQuery("#priceMin").val( value );										
				jQuery("#price_inner_sl_1").val( value );
										
				$.post("/ajax/",$('#catFilter').serialize(),function(data,status){
						if(status=='success')
						{
							if(data.status=='success')
							{
								document.location.reload();
							}else{
								console.log(data.message);
								}
						}
					},"json");
			});
			
			$('#price_inner_sl_2').bind('change', function(){
				var value = $(this).val();
			
				slider.update({
					to: value
				});
				
				jQuery("#priceMax").val( value );
				jQuery("#price_inner_sl_2").val( value );
										
				$.post("/ajax/",$('#catFilter').serialize(),function(data,status){
						if(status=='success')
						{
							if(data.status=='success')
							{
								document.location.reload();
							}else{
								console.log(data.message);
								}
						}
					},"json");
			});*/
// /PRICE SLIDER	

// QTY MANUFS COLUMN
/*function reloadMfsColumn(val){
	console.log (val);
	if (val === 2) {
			$('.two-column').removeClass('two-column');
			$('.four-column').removeClass('four-column');
			$('.factories__list').addClass('two-column');
		} else {
			$('.four-column').removeClass('four-column');
			$('.two-column').removeClass('two-column');
			$('.factories__list').addClass('four-column');
		};
	};*/
// /QTY MANUFS COLUMN

// TYPE MANUFS COLUMN
function reloadTabs(tab){
	console.log (tab);
	$('.filter-btn.active').removeClass('active');
	$('#tabFilter-' + tab).addClass('active');
	document.location.href = '#prod_tabs';
	
	};
// /TYPE MANUFS COLUMN

// TYPE MANUFS COLUMN
function reloadMfsColumn(val, loc){
	console.log (val);
	$.cookie("mf_list_type", val, {
		expires: 7,  // days
		path: RS,  // root
		secure: false // no https
	   });
	setTimeout(function(){
			document.location.href = loc;
		} ,50);
	};
// /TYPE MANUFS COLUMN

// TYPE MANUFS COLUMN
function reloadMfsAbc(val, loc){
	console.log (val);
	$.cookie("mf_abc", val, {
		expires: 7,  // days
		path: RS,  // root
		secure: false // no https
	   });
	setTimeout(function(){
			document.location.href = loc;
		} ,50);
	};
// /TYPE MANUFS COLUMN

// QTY PROD COLUMN
function reloadProdsColumn(val){
	console.log (val);
	$.cookie("pr_column", val, {
		expires: 7,  // days
		path: RS,  // root
		secure: false // no https
	   });
	setTimeout(function(){
			location.reload();
		} ,50);
	};
// /QTY PROD COLUMN	

// QTY PROD LIST
function reloadProdsQty(val, loc){
	console.log (val);
	$.cookie("pr_qty", val, {
		expires: 7,  // days
		path: RS,  // root
		secure: false // no https
	   });
	setTimeout(function(){
			document.location.href = loc;
		} ,50);
	};
// /QTY PROD LIST

// SORT PROD LIST
function reloadPriceLine(val){
	$.cookie("price_line", val, {
		expires: 7,  // days
		path: RS,  // root
		secure: false // no https
	   });
	setTimeout(function(){
			location.reload();
		} ,50);
	};
// /SORT PROD LIST	

// SORT PROJECT LIST
function reloadProjectLine(val, loc){
	$.cookie("project_line", val, {
		expires: 7,  // days
		path: RS,  // root
		secure: false // no https
	   });
	setTimeout(function(){
			document.location.href = loc;
		} ,50);
	};
// /SORT PROJECT LIST	

// SITE CURRENCY

function openCurrency(){
		$('.curr_lang_nav').toggleClass( 'active' );
	};
function reloadCurrency(val){
	$.cookie("rete_prefix", val, {
        expires: 7,  // days
        path: RS,  // root
        secure: false // no https
       });
	
	$.post(RS+"ajax/",{action:"clearFilter"},function(f_data,f_status){
			if(f_status=='success'){
					location.reload();
				}
		},"json");
	
	//$('#priceMin').val($.fn.filter_price_min);
	//$('#priceMax').val($.fn.filter_price_max);
	
	};
// /SITE CURRENCY

// SITE LANGUAGE
function openLang(){
		$('.curr_price_nav').toggleClass( 'active' );
	};
	
function reloadLang(val, cur_url){
	$.cookie("lang_prefix", val, {
        expires: 7,  // days
        path: RS,  // root
        secure: false // no https
       });
	setTimeout(function(){
			document.location.href = RS+cur_url;
		} ,250);
	};
// /SITE LANGUAGE

// SITE SEARCH
function reloadSaerch(lang, val){
	$.cookie("site_search", val, {
        expires: 7,  // days
        path: RS,  // root
        secure: false // no https
       });
	setTimeout(function(){
			document.location.href = '/'+lang+'/search/';
		} ,1000);
	};
// /SITE SEARCH

// Catalog Pages
function goCatalogPage(i){
		if(i < 1) return null;
		
		$('#catPageField').val(i);
		//$('#catFilter').submit();
		document.location.href = $.fn.curr_url + '?page=' + i;
	}
 

function goCatalogPage(i){
		if(i < 1) return null;
		
		$('#catPageField').val(i);
		//$('#catFilter').submit();
		document.location.href = $.fn.curr_url + '?page=' + i;
	}
// / Catalog Pages	

	
//*************************************************************************
//
// MAIN SCRIPT
//
//*************************************************************************


	
var mainScript = {
			
catProductsFilterReload: function(){
				$.post(RS+"ajax/",$('#catFilter').serialize(),function(data,status){
						if(status=='success')
						{
							if(data.status=='success')
							{
								document.location.reload();
							}else{
								console.log(data.message);
								}
						}
					},"json");
			},
			

		
userLogin: function(loc){
    		$('#authForm .response').html("Авторизация...");

			$.post(
					RS+"ajax/login/",
				
					$('#authForm').serialize(),
				
					function(data,status)
					{ 
						if(status=='success')
						{
							$('#authForm .response').html('<small>' + data.message + '</small>');						
							$('#authForm .response').css('line-height', '40px');

							if(data.status=='success')
							{
								$('#authForm')[0].reset();
								
								setTimeout(function(){
									document.location.href = loc;
									},3000);
									
							}

						}else{
							$('#authForm .response').html("Server response error :(");
						}
					},
				
					"json"
				);
				
    	},
		
			
sendNewPass: function(loc){
    		$('#newPassForm .response').html("Запись данных в базу...");

			$.post(
					RS+"ajax/sendNewPass/",
				
					$('#newPassForm').serialize(),
				
					function(data,status)
					{ 
						if(status=='success')
						{
							$('#newPassForm .response').html('<small>' + data.message + '</small>');							
							$('#newPassForm .response').css('line-height', '40px');

							if(data.status=='success')
							{
								$('#newPassForm')[0].reset();
								setTimeout(function(){
									document.location.href = loc;
									},4000);
							}

						}else{
							$('#newPassForm .response').html("Server response error :(");						
							$('#newPassForm .response').css('line-height', '40px');
						}
					},
				
					"json"
				);
    	},					
			
userRegister: function(loc){
    		$('#regForm .response').html("Запись данных в базу...");

			$.post(
					RS+"ajax/register/",
				
					$('#regForm').serialize(),
				
					function(data,status)
					{ 
						if(status=='success')
						{
							$('#regForm .response').html('<small>' + data.message + '</small>');							
							$('#regForm .response').css('line-height', '40px');

							if(data.status=='success')
							{
								$('#regForm')[0].reset();
								setTimeout(function(){
									document.location.href = loc;
									},4000);
							}

						}else{
							$('#regForm .response').html("Server response error :(");						
							$('#regForm .response').css('line-height', '40px');
						}
					},
				
					"json"
				);
    	},
		
userPersInfo: function(){
    		$('#persInfoForm .response').html("Запись данных в базу...");

			$.post(
					RS+"ajax/changePersInfo/",
				
					$('#persInfoForm').serialize(),
				
					function(data,status)
					{ 
						if(status=='success')
						{
							$('#persInfoForm .response').html('<small>' + data.message + '</small>');							
							$('#persInfoForm .response').css('line-height', '40px');

							if(data.status=='success')
							{
								setTimeout(function(){
									$('#persInfoForm .response').css('line-height', '0px');
									},4000);
							}

						}else{
							$('#persInfoForm .response').html("Server response error :(");						
							$('#persInfoForm .response').css('line-height', '40px');
						}
					},
				
					"json"
				);
    	},	
		
userChangePass: function(){
    		$('#changePasswordForm .response').html("Запись данных в базу...");

			$.post(
					RS+"ajax/userChangePass/",
				
					$('#changePasswordForm').serialize(),
				
					function(data,status)
					{ 
						if(status=='success')
						{
							$('#changePasswordForm .response').html('<small>' + data.message + '</small>');							
							$('#changePasswordForm .response').css('line-height', '40px');

							if(data.status=='success')
							{
								$('#changePasswordForm')[0].reset();
								setTimeout(function(){
									$('#changePasswordForm .response').css('line-height', '0px');
									document.location.reload();
									},4000);
							}

						}else{
							$('#changePasswordForm .response').html("Server response error :(");						
							$('#changePasswordForm .response').css('line-height', '40px');
						}
					},
				
					"json"
				);
    	},	
		
			
		
callOffOrder: function(order_id){
    		$('#history .response').html("Запись данных в базу...");

			$.post(
					RS+"ajax/callOffOrder/",
					{order_id:order_id},
				
					function(data,status)
					{ 
						if(status=='success')
						{
							$('#history .response').html('<small>' + data.message + '</small>');							
							$('#history .response').css('line-height', '40px');

							if(data.status=='success')
							{
								setTimeout(function(){
									$('#history .response').css('line-height', '0px');
									document.location.reload();
									},4000);
							}

						}else{
							$('#history .response').html("Server response error :(");						
							$('#history .response').css('line-height', '40px');
						}
					},
				
					"json"
				);
    	},	
		
addToLike: function(prod_id, prod_url){				
		$.post(		
		RS+"ajax/like/",
	
		{prod_id:prod_id, prod_url:prod_url},
				
		 function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{
						$('#prod'+prod_id+' div.p-item-response').html(data.message);
						$('.card  div.p-item-response').html(data.message);
						$('.card  div.p-item-response').css('height', '100%');
		    			$('#header_like').html(data.total_quant);
		    			$('#header_like').addClass('active');
						$('#prod'+prod_id+' div.p-item-response').css('height', '100%');
						$('#prod'+prod_id+' span.like').addClass('active');						
						$('.card span.like').addClass('active');
						setTimeout(function()
						{
							$('#prod'+prod_id+' div.p-item-response').css('height', '0');
							$('.card  div.p-item-response').css('height', '0');
						},2000);
						
					}else{
						$('body').append(data.message);
					}
					
				}else{
				$('#prod'+prod_id+' div.p-item-response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
					}
			},
		"json");
		},	
			
		
addToView: function(prod_id){				
		$.post(		
		RS+"ajax/viewed/",
	
		{prod_id:prod_id},
				
		 function(data,status){
				if(status=='success')
				{					
				}
				else{
				comsole.log('Ошибка сервера, пожалуйста повторите попытку позже.');
					}
			},
		"json");
		},	
		
delFromLike: function(item_id){				
		$.post(		
		RS+"ajax/delLike/",
	
		{item_id:item_id},
				
		 function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{
						$('#prod'+item_id+' div.p-item-response').html(data.message);
		    			$('#header_like').html(data.total_quant);
						$('#prod'+item_id).slideToggle("slow");
						setTimeout(function()
						{
							$('#prod'+item_id).remove();
						},600);
					}else{
						$('body').append(data.message);
					}
					
				}else{
				$('#prod'+prod_id+' div.p-item-response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
					}
			},
		"json");
		},				
		
addToCart: function(){				
		$.post(		
		RS+"ajax/toCart/",
	
		$('#toCartForm').serialize(),
				
		 function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{
								
						ga('send','event','shopping_cart','add');
							
						$('#toCartForm .response').html(data.message);
		    			$('#toCartForm .response').css('width', '100%');
						$('#header_cart').html(data.total_quant);
						$('#header_cart_sum').html(data.total_sum);						
						$('#modalCartQty').html(data.total_quant);
						$('#modalCartSum').html(data.total_sum);						
						$('#cartPageSum').html(data.total_sum);
						$('#prodCartList').html(data.fastCartHtml);												
						$('#prodCartList').parent().removeClass('hide');
						$('#cartOpen').attr('href', data.open_modal);					
						$('#modalOrder').attr('href', data.open_order);
						
						setTimeout(function()
						{
							$('#toCartForm .response').css('width', '0');
						},3000);
					}else{
						$('#toCartForm .response').html(data.message);
		    			$('#toCartForm .response').css('width', '100%');
						setTimeout(function()
						{
							$('#toCartForm .response').css('width', '0');
						},4000);
					}
					
					
				}else{
				$('#toCartForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
					}
			},
		"json");
		},	
		
changeProdSize: function(item_id, size){					
		$.post(
		RS+"ajax/prodSize/", 
		
		{item_id:item_id, size:size},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{		
						$('#product-size'+item_id+'-dd  li.active').removeClass('active');
						$('#product-size'+item_id+'-dd  li#size-val-'+size).addClass("active");						
						$('#product-size'+item_id+'-dd').toggle(500);
						$('#product-selected-size' + item_id).html(size);						
						$('#size' + item_id).val(size);
						
					}else{
						$('#orderForm .response').html(data.message);
					}
					
				}else{
				$('#orderForm .response').html('Ошибка сервера, свяжитесь с администратором.');
					}
			},
		"json");
		
		/* change visual size chars list */
		jQuery("#cart-item-"+item_id+" ul li.prod_size_char.active").removeClass('active');
		jQuery("#cart-item-"+item_id+" ul li.prod_size_char.prod_size_"+size).addClass('active');
		
		},	

changeProdQty: function(item_id, qty, prod_id){
		$.post(
		RS+"ajax/prodQty/", 
		
		{item_id:item_id, qty:qty, prod_id:prod_id},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{		
						$('#h-cart-pqty-' + item_id).html(qty);				
						$('#cartProdSum-'+item_id).html(data.prod_sum);
						$('#header_cart').html(data.total_quant);						
						$('#header_cart_sum').html(data.total_sum);						
						$('#cartPageSum').html(data.total_sum);
						
						$('#orderForm .response').css('line-height', '40px');
						$('#orderForm .response').html(data.message);
						
						setTimeout(function()
						{
							$('#orderForm .response').css('line-height', '0px');
						},4000);
											
					}else{
						$('#orderForm .response').html(data.message);
					}
					
				}else{
				$('#orderForm .response').html('Ошибка сервера, свяжитесь с администратором.');
					}
			},
		"json");
		},
		
delCartProd: function(item_id){					
		$.post(
		RS+"ajax/delCartProd/", 
		
		{item_id:item_id},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{							
						$('#cart-item-'+item_id).slideToggle("slow");
						$('#h-cart-item-'+item_id).slideToggle("slow");
						$('#header_cart').html(data.total_quant);						
						$('#header_cart_sum').html(data.total_sum);					
						$('#cartPageSum').html(data.total_sum);
						$('#cartOpen').attr('href', data.open_modal);					
						$('#modalOrder').attr('href', data.open_order);
							
												
						setTimeout(function(){
							$('#cart-item-'+item_id).remove();
							$('#h-cart-item-'+item_id).remove();
						},1000);
							
						
					}else{
						$('#orderForm .response').html(data.message);
					}
					
				}else{
				$('#orderForm .response').html('Ошибка сервера, свяжитесь с администратором.');
					}
			},
		"json");
		},
		
/*cahangeMfList: function(_letter){					
		$.post(
		RS+"ajax/cahangeMfList/", 
		
		{letter:_letter},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{							
						$('#mfList.factories__list').removeClass('factories__list');
						$('.factories__sorting').removeClass('hide');
						$('#mfList').addClass('factories');
						$('#mfList').html(data.fastMfHtml);					
						$('#countMf').html(data.mf_qty);
							
						
					}else{
						$('#mfList .response').css('line-height', '40px');
						$('#mfList .response').html(data.message);
						
						setTimeout(function()
						{
							$('#mfList .response').css('line-height', '0px');
						},4000);
					}
					
				}else{
						$('#mfList .response').css('line-height', '40px');
						$('#mfList .response').html('Ошибка сервера, свяжитесь с администратором.');
						
						setTimeout(function()
						{
							$('#mfList .response').css('line-height', '0px');
						},4000);
					}
			},
		"json");
		},	*/	
		
		
cartProdComment: function(item_id, comment){	
		
		console.log(comment);					
		$.post(
		RS+"ajax/cartProdComment/", 
		
		{item_id:item_id, comment:comment},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{	
						$('#orderForm .response').css('line-height', '40px');							
						$('#orderForm .response').html(data.message);
						setTimeout(function()
						{
							$('#orderForm .response').css('line-height', '0px');
						},4000);
					}else{
						$('#orderForm .response').html(data.message);
					}
					
				}else{
				$('#orderForm .response').html('Ошибка сервера, свяжитесь с администратором.');
					}
			},
		"json");
		},		
		
	
addNewOrder: function(){	
								
			$.post(		
			RS+"ajax/order/",
		
			$('#modalOrderForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{	
							ga('send','event','request','sent_request');
							
							$('div.cart_prod_item').slideToggle("slow");
							$('#thanksForm .response').html(data.message);
							$('#thanksForm .response').css('line-height', '40px');
							$('#header_cart').html("0");						
							$('#header_cart_sum').html("0");						
							$('#modalCartQty').html("0");
							$('#modalCartSum').html("0");						
							$('#cartPageSum').html("0");
							$('#cartOpen').attr('href', "#");					
							$('#modalOrder').attr('href', "#");
														
							console.log(data.message);							
						
							setTimeout(function(){
								$('div.buy-item').remove();								
								},500);
								
							setTimeout(function(){
								document.location.href = "#thanks-you";							
								},800);	
						}else{
							$('#modalOrderForm .response').html(data.message);
							$('#modalOrderForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#modalOrderForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},
			
addSiteComm: function(){	
								
			$.post(		
			RS+"ajax/addSiteComm/",
		
			$('#siteCommForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							$('#siteCommForm .response').html(data.message);
							$('#siteCommForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#siteCommForm')[0].reset(); 
								$('#siteCommForm .response').css('line-height', '0px');
								$('#siteCommForm .response').html('');
								},3000);
							
							console.log(data.message);
						}else{
							$('#siteCommForm .response').html(data.message);
							$('#siteCommForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#prodCommForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},
			
addProdComm: function(){	
								
			$.post(		
			RS+"ajax/addProdComm/",
		
			$('#prodCommForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							$('#prodCommForm .response').html(data.message);
							$('#prodCommForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#prodCommForm')[0].reset(); 
								$('#prodCommForm .response').css('line-height', '0px');
								$('#prodCommForm .response').html('');
								document.location.reload();
								},3000);
							
							console.log(data.message);
						}else{
							$('#prodCommForm .response').html(data.message);
							$('#prodCommForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#prodCommForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},
			
addArtComm: function(){	
								
			$.post(		
			RS+"ajax/addArtComm/",
		
			$('#artCommForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							$('#artCommForm .response').html(data.message);
							$('#artCommForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#artCommForm')[0].reset(); 
								$('#artCommForm .response').css('line-height', '0px');
								$('#artCommForm .response').html('');
								document.location.reload();
								},3000);
							
							console.log(data.message);
						}else{
							$('#artCommForm .response').html(data.message);
							$('#artCommForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#artCommForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},						
			
addContactMessage: function(){	
								
			$.post(		
			RS+"ajax/contactForm/",
		
			$('#contactForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							$('#contactForm .response').html(data.message);
							$('#contactForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#contactForm')[0].reset(); 
								$('#contactForm .response').css('line-height', '0px');
								$('#contactForm .response').html('');
								},3000);
							
							console.log(data.message);
						}else{
							$('#contactForm .response').html(data.message);
							$('#contactForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#contactForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},	
			
minusProdQty: function(id){
				var $input = $('#sum_'+id).find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();
				return false;
			},

plusProdQty: function(id){
				var $input = $('#sum_'+id).find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			},
			
callback: function(loc){	
								
			$.post(		
			RS+"ajax/callback/",
		
			$('#callbackForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							ga('send','event','call_request','sent_request');
							
							$('#callbackForm .response').html(data.message);
							$('#callbackForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#callbackForm')[0].reset(); 
								$('#callbackForm .response').css('line-height', '0px');
								$('#callbackForm .response').html('');
								},3000);
								
							setTimeout(function(){
									document.location.href = loc;
									},4000);	
							
							console.log(data.message);
						}else{
							$('#callbackForm .response').html(data.message);
							$('#callbackForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#callbackForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},	
			
addNewMeeting: function(loc){	
								
			$.post(		
			RS+"ajax/meeting/", 
		
			$('#meetingForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							$('#meetingForm .response').html(data.message);
							$('#meetingForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#meetingForm')[0].reset(); 
								$('#meetingForm .response').css('line-height', '0px');
								$('#meetingForm .response').html('');
								},3000);
								
							setTimeout(function(){
									document.location.href = loc;
									},4000);	
							
							console.log(data.message);
						}else{
							$('#meetingForm .response').html(data.message);
							$('#meetingForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#meetingForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},				
			
subscribe: function(loc){	
								
			$.post(		
			RS+"ajax/subscribe/",
		
			$('#subscribeForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							ga('send','event','subscribe','sent_request');
							
							$('#subscribeForm .response').html(data.message);
							$('#subscribeForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#subscribeForm')[0].reset(); 
								$('#subscribeForm .response').css('line-height', '0px');
								$('#subscribeForm .response').html('');
								},3000);
								
							setTimeout(function(){
									document.location.href = loc;
									},4000);	
							
							console.log(data.message);
						}else{
							$('#subscribeForm .response').html(data.message);
							$('#subscribeForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#subscribeForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},
		
			
		
}
