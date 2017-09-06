var RS = "/";

$('#showCommForm').click(function(){
		$('#showCommForm').css('display', 'none');
		$('#artCommForm').toggle(200);
});

$('#showProdForm').click(function(){
		$('#showProdForm').css('display', 'none');
		$('#prodCommForm').toggle(200);
});

// PRICE SLIDER	
	/*
	jQuery("#Slider2").slider({ 
								from: $.fn.filter_price_min, 
								to: $.fn.filter_price_max, 
								step: 1, 
								dimension: '' 
								}); 
								// heterogeneity: ['50/50000'],
								*/
	
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
										
										jQuery("#priceMin").val( obj.fromNumber );
										jQuery("#priceMax").val( obj.toNumber );
										
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
// /PRICE SLIDER	

// SITE CURRENCY
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
function reloadLang(val){
	$.cookie("lang_prefix", val, {
        expires: 7,  // days
        path: RS,  // root
        secure: false // no https
       });
	setTimeout(function(){
			location.reload();
		} ,50);
	};
// /SITE LANGUAGE

// SITE SEARCH
function reloadSaerch(val){
	$.cookie("site_search", val, {
        expires: 7,  // days
        path: RS,  // root
        secure: false // no https
       });
	setTimeout(function(){
			document.location.href = '/search/';
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
			
userRegister: function(){
    		$('#regForm .response').html("Запись данных в базу...");

			$.post(
					RS+"home/register/",
				
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
									$('.auth-modal-sm').modal('hide');
									document.location.reload();
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
		
userLogin: function(){
    		$('#authForm .response').html("Авторизация...");

			$.post(
					RS+"home/login/",
				
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
									document.location.reload();
									},3000);
									
							}

						}else{
							$('#authForm .response').html("Server response error :(");
						}
					},
				
					"json"
				);
				
    	},
		
			
sendNewPass: function(){
    		$('#newPassForm .response').html("Запись данных в базу...");

			$.post(
					RS+"home/sendNewPass/",
				
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
									$('.auth-modal-sm').modal('hide');
									document.location.reload();
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
		
addToLike: function(prod_id, prod_url){				
		$.post(		
		RS+"home/like/",
	
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
		
delFromLike: function(item_id){				
		$.post(		
		RS+"home/delLike/",
	
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
		RS+"home/cart/",
	
		$('#toCartForm').serialize(),
				
		 function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{
						$('#toCartForm .response').html(data.message);
		    			$('#toCartForm .response').css('width', '200px');
						$('#header_cart').html(data.total_quant);
						$('#header_cart_sum').html(data.total_sum);						
						$('#modalCartQty').html(data.total_quant);
						$('#modalCartSum').html(data.total_sum);						
						$('#cartPageSum').html(data.total_sum);
						$('#prodCartList').html(data.fastCartHtml);						
						$('#cartOpen').attr('href', data.open_modal);					
						$('#modalOrder').attr('href', data.open_order);
						
						setTimeout(function()
						{
							$('#toCartForm .response').css('width', '0');
						},3000);
					}else{
						$('#toCartForm .response').html(data.message);
		    			$('#toCartForm .response').css('width', '200px');
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
		RS+"home/prodSize/", 
		
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

changeProdQty: function(item_id, qty, prod_id, rate){
		$.post(
		RS+"home/prodQty/", 
		
		{item_id:item_id, qty:qty, prod_id:prod_id, rate:rate},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{		
						$('#product-qty'+item_id+'-dd  li.active').removeClass('active');
						$('#product-qty'+item_id+'-dd  li#qty-val-'+qty).addClass("active");	
						$('#product-selected-qty' + item_id).html(qty);						
						$('#qty' + item_id).val(qty);						
						$('#price-val-'+item_id).html(data.prod_sum);
						$('#header_cart').html(data.total_quant);						
						$('#header_cart_sum').html(data.total_sum);						
						$('#modalCartQty').html(data.total_quant);
						$('#modalCartSum').html(data.total_sum);						
						$('#cartPageSum').html(data.total_sum);
						
					}else{
						$('#orderForm .response').html(data.message);
					}
					
				}else{
				$('#orderForm .response').html('Ошибка сервера, свяжитесь с администратором.');
					}
			},
		"json");
		},
		
delCartProd: function(item_id,rate){					
		$.post(
		RS+"home/delCartProd/", 
		
		{item_id:item_id, rate:rate},
				
		function(data,status){
				if(status=='success')
				{
					if(data.status=='success')
					{							
						$('#cart-item-'+item_id).slideToggle("slow");
						$('#header_cart').html(data.total_quant);						
						$('#header_cart_sum').html(data.total_sum);						
						$('#modalCartQty').html(data.total_quant);
						$('#modalCartSum').html(data.total_sum);						
						$('#cartPageSum').html(data.total_sum);
						$('#cartOpen').attr('href', data.open_modal);					
						$('#modalOrder').attr('href', data.open_order);
							
						
						setTimeout(function(){
							$('#emptyCart').html(data.fastCartHtml);
							$('#emptyCartPage').html(data.fastCartHtml);
						},500);
						
						setTimeout(function(){
							$('#cart-item-'+item_id).remove();
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
		
	
addNewOrder: function(){	
								
			$.post(		
			RS+"home/order/",
		
			$('#orderForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{	
							
							$('div.cart_prod_item').slideToggle("slow");
							$('#orderForm .response').html(data.message);
							$('#orderForm .response').css('line-height', '40px');
							$('#header_cart').html("0");						
							$('#header_cart_sum').html("0");						
							$('#modalCartQty').html("0");
							$('#modalCartSum').html("0");						
							$('#cartPageSum').html("0");
							$('#cartOpen').attr('href', "#");					
							$('#modalOrder').attr('href', "#");
							
						
							setTimeout(function(){$('div.buy-item').remove(); },800);
														
							console.log(data.message);
						}else{
							$('#orderForm .response').html(data.message);
							$('#orderForm .response').css('line-height', '40px');
						}
						
					}else{
						console.log(1);
					$('#orderForm .response').html('Ошибка сервера, пожалуйста повторите попытку позже.');
						}
				},
			"json");
			},
			
addProdComm: function(){	
								
			$.post(		
			RS+"home/addProdComm/",
		
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
			RS+"home/addArtComm/",
		
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
			
callback: function(){	
								
			$.post(		
			RS+"home/callback/",
		
			$('#callbackForm').serialize(),
					
			 function(data,status){
					if(status=='success')
					{
						
						if(data.status=='success')
						{								
							$('#callbackForm .response').html(data.message);
							$('#callbackForm .response').css('line-height', '40px');
							
						
							setTimeout(function(){
								$('#callbackForm')[0].reset(); 
								$('#callbackForm .response').css('line-height', '0px');
								$('#callbackForm .response').html('');
								document.location.reload();
								},3000);
							
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
			}
		
			
		
}
