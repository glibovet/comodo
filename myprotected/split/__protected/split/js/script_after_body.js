$(function(){
		on_start();
		
		$('#preload_wrapper').hide(200);
		
		if($.cookie('ajaxID')!='undefined' && $.cookie('ajaxID') != null)
		{
			$('#menuChild-'+parseInt($.cookie('ajaxID'))).click();
		}
	})


	
var global_table_filtr = "";
var global_tables = "";
var global_fields = "";
var global_card_data = "";

var global_ajaxFile = "";
var global_app_id = 0;

var global_f_fields = [];
var global_f_values = [];

var global_start_page = 1;
var global_on_page = 15;

var filtr_sem = false;
	
var checkSem = false;

var nonactiveMsg = 'Опция не активна, для активации необходимо отметить элементы из списка.';


	
function change_head(id){
		$('.head-app').hide();
		$('#head-app-'+id).show();
	}
	
function open_modal(ajaxFile,data)
{
	$('#modal-window').html('Loading...');
	$('#modal-window').load(ajaxFile,data,function(){
			$('#modal-window').show(200);
		});
}
function close_modal()
{
	$('#modal-window').html('');
	$('#modal-window').hide(200);
}

function load_create(ajaxFile)
{
	$('#inajax-1').html('<center>Loading...</center>');
	$('#inajax-1').load(ajaxFile);
}

function load_app_create(ajaxFile,card_data)
{
	$('#inajax-1').html('<center>Loading...</center>');
	var data = {card_data:card_data}
	$('#inajax-1').load(ajaxFile,data);
}

function load_card(ajaxFile,id)
{
	$('#inajax-1').html('<center>Loading...</center>');
	var data = {id:id}
	$('#inajax-1').load(ajaxFile,data);
}

function load_app_card(ajaxFile,id,card_data)
{
	$('#inajax-1').html('<center>Loading...</center>');
	var data = {id:id, card_data:card_data}
	$('#inajax-1').load(ajaxFile,data);
}

function load_order(ajaxFile,id)
{
	$('#inajax-1').html('<center>Loading...</center>');
	var data = {id:id}
	$('#inajax-1').load(ajaxFile,data);
}

function load_content(ajaxFile)
{
	$('#inajax-1').html('<center>Loading...</center>');
	var data = {
				ajaxpath:ajaxFile,
				start_page:1,
				on_page:10
				}
	$('#inajax-1').load(ajaxFile,data);
}


function load_app_content(ajaxFile,app_id)
{
	global_ajaxFile = ajaxFile;
	global_app_id = app_id;
	
	$('#inajax-1').html('<center>Loading...</center>');

	var data = {
				filtr_table:global_table_filtr,
				tables:global_tables,
				fields:global_fields,
				card_data:global_card_data,
						
				ajaxpath:ajaxFile,
				start_page:global_start_page,
				on_page:10,
				app_id:app_id,
				'f_fields[]':global_f_fields,
				'f_values[]':global_f_values,
				first_load:false
				}
	$('#inajax-1').load(ajaxFile,data);
}

function filtr_content(name,value)
{
	if(!filtr_sem)
	{
		global_start_page = 1;
	}else
	{
		filtr_sem = false;
	}
	//alert(name+' = '+value);
	
	var f_fields = [];
	var f_values = [];
	
	$('#filtr-wrap form input').each(function(){
			//alert($(this).attr('name')+" = "+$(this).val());
			
			f_fields.push($(this).attr('name'));
			f_values.push($(this).val());
		});
	$('#filtr-wrap form select').each(function(){
			//alert($(this).attr('name')+" = "+$(this).val());
			
			f_fields.push($(this).attr('name'));
			f_values.push($(this).val());
		});
		
	var cur_pos = f_fields.indexOf(name);
	
	f_values[cur_pos] = value;
		
	global_f_fields = f_fields;
	global_f_values = f_values;
	
	load_app_content(global_ajaxFile,global_app_id);
}

// Check functions

function select_all_checked()
	{
		if(checkSem)
		{
			$('input.table-checkbox').prop('checked',false);
			checkSem = false;
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').addClass('nonactive');
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').attr('title',nonactiveMsg);
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').css('cursor','auto');
		}else
		{
			$('input.table-checkbox').prop('checked',true);
			checkSem = true;
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').removeClass('nonactive');
			
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-new]').attr('title','Копировать');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-save]').attr('title','Опубликовать');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-close]').attr('title','Снять с публикации');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-delete]').attr('title','Удалить');
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').css('cursor','pointer');
		}
	}
	function scan_active_checked()
	{
		var cur_users = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_user_id = $(this).val();
				if(cur_user_id != 'null')
				{
					cur_users.push(cur_user_id);
				}
			});
		if(cur_users.length > 0)
		{
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').removeClass('nonactive');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-new]').attr('title','Копировать');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-save]').attr('title','Опубликовать');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-close]').attr('title','Снять с публикации');
			$('.r-z-h-saving button.first-actives[alt=r-z-h-s-delete]').attr('title','Удалить');
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').css('cursor','pointer');
		}else
		{
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').addClass('nonactive');
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').attr('title',nonactiveMsg);
			$('.r-z-h-saving button.first-actives[alt!=r-z-h-s-create]').css('cursor','auto');
		}
	}
	
	function show_is_delete_items(app_table)
	{
		var is_nonactive = $('#delete-checked-button').attr('class');
		if(is_nonactive != 'r-z-h-s-delete nonactive')
		{
			var data = {'answer_path':'split/ajax/modal/answer.delete.items.php', table:app_table}
			open_modal('split/ajax/modal/question.delete.items.php', data);
		}
	}
	
	function activate_items(app_table)
	{
		var is_nonactive = $('#activate-checked-button').attr('class');
		var cur_items = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_item_id = $(this).val();
				if(cur_item_id != 'null')
				{
					cur_items.push(cur_item_id);
					$('tr#'+cur_item_id+' td.publication div').attr('class','published');
					$('tr#'+cur_item_id+' td.publication span').html('Да');
				}
			});
		if(is_nonactive != 'r-z-h-s-save nonactive')
		{
			var data = { 'items[]':cur_items, table:app_table }
			$('#modal-window').load('split/ajax/modal/action.activate.items.php',data);
		}
	}
	function disactivate_items(app_table)
	{
		var is_nonactive = $('#activate-checked-button').attr('class');
		var cur_items = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_item_id = $(this).val();
				if(cur_item_id != 'null')
				{
					cur_items.push(cur_item_id);
					$('tr#'+cur_item_id+' td.publication div').attr('class','not-published');
					$('tr#'+cur_item_id+' td.publication span').html('Нет');
				}
			});
		if(is_nonactive != 'r-z-h-s-close nonactive')
		{
			var data = { 'items[]':cur_items, table:app_table }
			$('#modal-window').load('split/ajax/modal/action.disactivate.items.php',data);
		}
	}
	function copy_items(app_table)
	{
		var is_nonactive = $('#copy-checked-button').attr('class');
		var cur_items = [];
		$('input.table-checkbox[type=checkbox]:checked').each(function(){
				var cur_item_id = $(this).val();
				if(cur_item_id != 'null')
				{
					cur_items.push(cur_item_id);
				}
			});
		if(is_nonactive != 'r-z-h-s-new nonactive')
		{
			setTimeout(function(){
					$('#leap-forward').click();
				},1000);
			 
			var data = { 'items[]':cur_items, table:app_table }
			open_modal('split/ajax/modal/action.copy.items.php',data);
		}
	}

// ajax functions

function delete_media_item(appTable,id,field,path,filename)
{
	$('#ajax-getter').html('Delete media file...');
	$.post("split/ajax/heandlers/indexHeandler.php",{action:"deleteMediaFile",appTable:appTable,id:id,field:field,path:path,filename:filename},function(data,status){
			if(status=='success')
			{
				$('#media-item-'+field).hide(200);
				$('#ajax-getter').html(data.message);
				
				setTimeout(function(){
					$('#ajax-getter').fadeOut(500);
				},3000);
			}else
			{
				$('#ajax-getter').html("Tech error, ajax failed response.");
			}
		},"json");
}

function delete_media_item_ref(id,path)
{
	$('#ajax-getter').html('Delete media file...');
	$.post("split/ajax/heandlers/indexHeandler.php",{action:"deleteMediaFileRef",id:id,path:path},function(data,status){
			if(status=='success')
			{
				$('#media-item-'+id).hide(200);
				$('#ajax-getter').html(data.message);
				
				setTimeout(function(){
					$('#ajax-getter').fadeOut(500);
				},3000);
			}else
			{
				$('#ajax-getter').html("Tech error, ajax failed response.");
			}
		},"json");
}

function loadPage(parent,alias,id,item_id,action_type,params)
{
	$.cookie('ajaxID',id);
	
	$("body").css("cursor", "progress");
	$("a").css("cursor", "progress");
	
	var postData = {parent:parent,alias:alias,id:id,item_id:item_id,action_type:action_type,'params':params}
	
	$.post('split/ajax/pages/'+parent+'/'+alias+'.php',postData,function(data,status){
			$("body").css("cursor", "auto");
			$("a").css("cursor", "auto");
			
			if(status='success')
			{
				$('#r-z-header').html(data.headContent);
				$('#sub-r-z-content').html(data.bodyContent);
				if(action_type=='landingPage')
				{
					reset_filter_params();
					if(data.filter.f1==1) open_filtr(1);
					if(data.filter.f2==1) open_filtr(2);
					if(data.filter.f3==1) open_filtr(3); 
				}
				if(action_type=='cardEdit')
				{
					// redacot ini
					$('.redactor').redactor({
						imageUpload: 'redactor/demo/scripts/image_upload.php'
					});
					
					if(alias=='order-form')
					{
						// start of autocomplete
						
						var options, ac;
						//var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
						options = { 
								source: function(request, response, url)
										{
               						 		var searchParam  = request.term;

    										$.ajax({
              										url: 'split/ajax/heandlers/handle/handle.json.usersAutocomplete.php',
             										data : searchParam,
             										dataType: "json",
            										type: "POST",
            										success: function (data)
															{
																alert(1);
                    											//response($.map(data, function(item){ return { label:item.Firstname, value:item.FirstName } } ));
															}
            										});//ajax ends 
            							}
									}
							/*
							source: 'split/ajax/heandlers/handle/handle.json.usersAutocomplete.php',
							
							serviceUrl:'split/ajax/heandlers/handle/handle.json.usersAutocomplete.php',
							
							onSelect: function(){ 
								$('#save-user_id').val(value.data); 
								}
							*/
							
						ac = $('#autocomplete-user_select').autocomplete(options); 
						
						// end of autocomplete
					}
					
					// ajax form ini
					$('form[name=cardEditForm]').ajaxForm({
						dataType:"json",
						success:function(data, status){
								if(status=='success')
								{
									$('#ajax-getter').html(data.message);
									
									setTimeout(function(){
											$('#ajax-getter').fadeOut(500);
										},3000);
									
									switch(data.choice)
									{
										case 1:
										{
											loadPage(parent,alias,id,item_id,'cardView',params);
											break;
										}
										case 2:
										{
											loadPage(parent,alias,id,0,'landingPage',{})
											break;
										}
										case 3:
										{
											loadPage(parent,alias,id,item_id,action_type,params)
											break;
										}
										case 4:
										{
											loadPage(parent,alias,id,0,'cardCreate',{copyItem:item_id})
											break;
										}
										default:
										{
											break;
										}
									}
								}else
								{
									$('#ajax-getter').html('Ajax responce error');
								}
							}
						});
						
				} // end of Edit
				if(action_type=='cardCreate')
				{
					// redacot ini
					$('.redactor').redactor({
						imageUpload: 'redactor/demo/scripts/image_upload.php'
					});
					
					// ajax form ini
					$('form[name=cardEditForm]').ajaxForm({
						dataType:"json",
						success:function(data, status){
								if(status=='success')
								{
									$('#ajax-getter').html(data.message);
									
									setTimeout(function(){
											$('#ajax-getter').fadeOut(500);
										},3000);
									
									switch(data.choice)
									{
										case 1:
										{
											loadPage(parent,alias,id,data.item_id,'cardView')
											break;
										}
										case 2:
										{
											loadPage(parent,alias,id,0,'landingPage',{})
											break;
										}
										case 3:
										{
											loadPage(parent,alias,id,data.item_id,'cardEdit',params)
											break;
										}
										case 4:
										{
											loadPage(parent,alias,id,0,'cardCreate',{copyItem:data.item_id});
											break;
										}
										default:
										{
											$('#ajax-getter').html('Unknown choice processor num.');
											break;
										}
									}
								}else
								{
									$('#ajax-getter').html('Ajax responce error');
								}
							}
						});
					
				} // end of Create
			}else{
					alert("Failed ajax response!");
				}
		},"json");
}


// auto update alias by name
	
	function change_alias()
	{
		var str = $('#save-name').val().toLowerCase();
		
		str = str.replace(/а/g,'a');
		str = str.replace(/б/g,'b');
		str = str.replace(/в/g,'v');
		str = str.replace(/г/g,'g');
		str = str.replace(/д/g,'d');
		str = str.replace(/е/g,'e');
		str = str.replace(/ё/g,'yo');
		str = str.replace(/ж/g,'zh');
		str = str.replace(/з/g,'z');
		str = str.replace(/и/g,'i');
		str = str.replace(/й/g,'y');
		str = str.replace(/к/g,'k');
		str = str.replace(/л/g,'l');
		str = str.replace(/м/g,'m');
		str = str.replace(/н/g,'n');
		str = str.replace(/о/g,'o');
		str = str.replace(/п/g,'p');
		str = str.replace(/р/g,'r');
		str = str.replace(/с/g,'s');
		str = str.replace(/т/g,'t');
		str = str.replace(/у/g,'u');
		str = str.replace(/х/g,'h');
		str = str.replace(/ф/g,'f');
		str = str.replace(/ц/g,'c');
		str = str.replace(/ч/g,'ch');
		str = str.replace(/ш/g,'sh');
		str = str.replace(/щ/g,'shс');
		str = str.replace(/ъ/g,'');
		str = str.replace(/ы/g,'u');
		str = str.replace(/ь/g,'');
		str = str.replace(/э/g,'e');
		str = str.replace(/ю/g,'yu');
		str = str.replace(/я/g,'ya');
		
		str = str.replace(/[^a-z,\d,-]/g,'-');
		str = str.replace(/\,/g,'-');
		str = str.replace(/-+/g,'-');
		str = str.replace(/^-+/g,'');
		str = str.replace(/-+$/g,'');
		
		$('#save-alias').attr('value',str);
	}