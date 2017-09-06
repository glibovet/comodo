$(function()
	{ 
		$('#inspector-left').load('ajax/pages/menu/tables.menu.php');
		$('#inspector-right').load('ajax/pages/content/tables.content.php');
	}
); 

var loader = '<center><img align="Loading..." src="img/pulse.gif"></center>';

function load_menu(filename)
{
	$('#inspector-left').html(loader);
	$('#inspector-right').html(loader);
	
	$('#inspector-left').load('ajax/pages/menu/'+filename+'.menu.php');
	$('#inspector-right').load('ajax/pages/content/'+filename+'.content.php');	
	
	$('#inspector-menu ul li').removeClass('active');
	$('#inspector-menu ul li[inspector_rel='+filename+']').addClass('active');	
}

function load_sub_menu(type,name)
{
	$('#inspector-right').html(loader);
	
	$('#inspector-right').load('ajax/load/'+type+'.load.php?name='+name);	
	
	$('#inspector-left ul li').removeClass('active');
	$('#inspector-left ul li[inspector_rel='+name+']').addClass('active');
}

function saving_edit()
{
	$('#save_result').html('Saving...');
	$('#save_result').show(400);
			setTimeout(function(){
					$('#loadProgress').html('');
					$('#save_result').html('Операция сохранения выполнена успешно.');
				},400);
}