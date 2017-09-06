$(document).ready(function(){
	
	$('select.makeMeFancy').tzSelect({
		render : function(option){
			return $('<li>',{
				html:	'<img src="'+option.data('icon')+'" /><span>'+
						option.data('html-text')+'</span>'
			});
		},
		className : 'hasDetails'
	});
	
	// Calling the default version of the dropdown
	$('select.sampling_changed').tzSelect('');
	$('select#numb-of-items').tzSelect('numb-of-items');
	
	//$('select#numb-of-items').tzSelect();
});