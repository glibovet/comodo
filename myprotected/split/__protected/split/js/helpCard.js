	function change_rotator(id,place,loos)
	{
		$('#'+id+'-'+place).addClass('active');
		$('#'+id+'-'+loos).removeClass('active');

		$('#radio-'+id+'-'+place).prop("checked",true);;
	}
	
	function submit_save_form(choice)
	{
		$('#ajax-getter').html('Saving...');
		
		$('#ajax-getter').show();
		
		$('#formSaveChoice').val(choice);
		
		$('form[name=cardEditForm]').submit();		
	}
	
	function submit_create_form(choice)
	{
		$('#ajax-getter').html('Creating...');
		
		$('#ajax-getter').show();
		
		$('#formSaveChoice').val(choice);
		
		$('form[name=cardEditForm]').submit();
	}
	
	function reload_extra_fields(id)
	{
		$('#wp-form-extra-fields-wrap').html('Loading...');
		$('#wp-form-extra-fields-wrap').load(wp_folder+'ajax/load/reload-cat-group-chars.php?id='+id+'&pid='+card_id);
	}
	
	function split_txt(txt)
	{
		var n = txt.lastIndexOf("\\");
		//alert(txt.substr(n+1));
		$('#save-editor-input-file').attr('value',txt.substr(n+1));
	}
	
	function check_file()
	{
		$('#editor-file-input').click();
	}
	function uncheck_file()
	{
		$('#editor-file-input').attr('value','');
		$('#save-editor-input-file').attr('value','../');
	}
	
	function delete_rf(id)
	{
		$('#rf-item-'+id).load(wp_folder+'ajax/load/delete-ref-file.php?id='+id,function(){
				$('#rf-item-'+id).hide(400);
		});
	}
	
	function updateProductCharsForm(product_cat_id,charsGroup,chars,cat_id)
	{
		var postData = {product_cat_id:product_cat_id, charsGroup:charsGroup, chars:chars, cat_id:cat_id}
		$.post("split/ajax/load/action.json.productCharsForm.php",postData,function(data,status){
				if(status=='success')
				{
					$('#wp-form-extra-fields-wrap').html(data.message);
				}
			},"json");
	}