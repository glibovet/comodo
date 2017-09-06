(function($){
	
	$.fn.tzSelect = function(id,options){
		options = $.extend({
			render : function(option){
					if(id == 'numb-of-items') // || id == 'r-z-c-f-sort-amount'
					{
						var cur_li = $('<li onclick="change_onpage('+option.text()+');">',{
							//html : option.text() 
							});
					}else
					{
						if(id == 'r-z-c-f-sort-order')
						{
							//var cur_li = $('<li onclick="change_orderpage(\''+option.val()+'\');">',{
							var cur_li = $('<li onclick="filtr_content(\''+option.attr('name')+'\',\''+option.val()+'\');">',{
								//html : option.text() 
								});
						}else
							{
								if(id == 'r-z-c-f-sort-by')
								{
									//var cur_li = $('<li onclick="change_sortpage(\''+option.val()+'\');">',{
									var cur_li = $('<li onclick="filtr_content(\''+option.attr('name')+'\',\''+option.val()+'\');">',{
										//html : option.text() 
										});
								}else
								var cur_li = $('<li onclick="filtr_content(\''+option.attr('name')+'\',\''+option.val()+'\');">',{
								//html : option.text() 
								});
							}
					}
				cur_li.html(option.text());
				return cur_li;
			},
			className : 'dropDown'
		},options);
		
		return this.each(function(){
			
			// The "this" points to the current select element:
			
			var select = $(this);
		
			var selectBoxContainer = $('<div>',{
				width		: select.outerWidth(),
				className	: 'tzSelect'
				//html		: '<div class="selectBox"></div>'
			});
			
			selectBoxContainer.attr('class','tzSelect');
			selectBoxContainer.append('<div class="selectBox"></div>');
		
			var dropDown = $('<ul>',{className:'dropDown'});
			var selectBox = selectBoxContainer.find('.selectBox');
			
			// Looping though the options of the original select element

			if(options.className){
				dropDown.addClass(options.className);
			}
			
			select.find('option').each(function(i){
				var option = $(this);
		
				if(i==select.attr('selectedIndex')){
					selectBox.html(option.text());
				}
				
				// As of jQuery 1.4.3 we can access HTML5 
				// data attributes with the data() method.
				
				if(option.data('skip')){
					return true;
				}
				
				// Creating a dropdown item according to the
				// data-icon and data-html-text HTML5 attributes:
				
				var li = options.render(option);

				li.click(function(){
					
					selectBox.html(option.text());
					dropDown.trigger('hide');
					
					// When a click occurs, we are also reflecting
					// the change on the original select element:
					select.val(option.val());
					
					return false;
				});
		
				dropDown.append(li);
			});
			
			selectBoxContainer.append(dropDown.hide());
			select.hide().after(selectBoxContainer);
			
			// Binding custom show and hide events on the dropDown:
			
			dropDown.bind('show',function(){
				
				if(dropDown.is(':animated')){
					return false;
				}
				
				$('.selectBox').removeClass('expanded');
				$('.dropDown').hide();
				
				selectBox.addClass('expanded');
				dropDown.slideDown(100);
				
			}).bind('hide',function(){
				
				if(dropDown.is(':animated')){
					return false;
				}
				
				selectBox.removeClass('expanded');
				dropDown.slideUp(100);
				
			}).bind('toggle',function(){
				if(selectBox.hasClass('expanded')){
					dropDown.trigger('hide');
				}
				else dropDown.trigger('show');
			});
			
			selectBox.click(function(){
				dropDown.trigger('toggle');
				return false;
			});
		
			// If we click anywhere on the page, while the
			// dropdown is shown, it is going to be hidden:
			
			$(document).click(function(){
				dropDown.trigger('hide');
			});

		});
	}
	
})(jQuery);