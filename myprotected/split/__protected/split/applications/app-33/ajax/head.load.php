<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	$create_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/create.load.php";
	$content_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/content.load.php";
 ?>
			<div class="head-app" id="head-app-1">
            <div class="r-z-h-filter"> 
            	<button class="r-z-h-f-search but-sort" id="but-sort-1" type="button" onclick="open_filtr(1);"></button>
                <button class="r-z-h-f-filling but-sort" id="but-sort-2" type="button" onclick="open_filtr(2);"></button>
                <button class="r-z-h-f-sorting but-sort" id="but-sort-3" type="button" onclick="open_filtr(3);"></button>
            </div><!-- r-z-h-filter -->
            
            <div class="r-z-h-saving">
                <button class="r-z-h-s-delete nonactive first-actives" type="button" title="Опция не активна, для активации необходимо отметить елементы из списка." 
                		id="delete-checked-button" onclick="show_is_delete_stock_orders();"></button>
                
                <button class="r-z-h-s-create" type="button" onclick="change_head(2);  load_create(create_path);" title="Создать заявку">Создать &nbsp;&nbsp;&nbsp;<span>+</span></button>
            </div><!-- r-z-h-saving -->	
			</div>

			<div class="head-app head-hidden" id="head-app-2">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1); load_app_content(content_path,<?php echo $app_id ?>);">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            
            <div class="r-z-h-saving">
            	<button class="r-z-h-s-new" type="button" title="Сохранить и дублировать" onclick="submit_create_form(1);"></button>
                <button class="r-z-h-s-save" type="button" title="Сохранить и редактировать" onclick="submit_create_form(2);"></button>
                <button class="r-z-h-s-close" type="button" title="Сохранить и закрыть" onclick="submit_create_form(3);"></button>
                <button class="r-z-h-s-create" type="button" title="Сохранить и создать" onclick="submit_create_form(4);">Создать &nbsp;&nbsp;&nbsp;<span>+</span></button>
            </div><!-- r-z-h-saving -->	
            </div>
            
            <div class="head-app head-hidden" id="head-app-3">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1); load_app_content(content_path,<?php echo $app_id ?>);">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            
            <div class="r-z-h-saving">
            	<button class="r-z-h-s-new" type="button" title="Сохранить и дублировать" onclick="submit_save_form(1);"></button>
                <button class="r-z-h-s-save" type="button" title="Сохранить и редактировать" onclick="submit_save_form(2);"></button>
                <button class="r-z-h-s-close" type="button" title="Сохранить и закрыть" onclick="submit_save_form(3);"></button>
                <button class="r-z-h-s-create" type="button" title="Сохранить и создать" onclick="submit_save_form(4);">Сохранить &nbsp;&nbsp;&nbsp;<span>+</span></button>
            </div><!-- r-z-h-saving -->	
            </div>
            
            <div class="head-app head-hidden" id="head-app-4">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1); load_app_content(content_path,<?php echo $app_id ?>);">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            
            <div class="r-z-h-saving">
                <button class="r-z-h-s-create nonactive" id="get_order_button" type="button" title="Опция стент активна только после отметки всех товаров из заявки" onclick="get_order();">Принять</button>
            </div><!-- r-z-h-saving -->	
            </div>

<script type="text/javascript" language="javascript">
	$(function(){
			$('.nonactive').css('cursor','auto');
		});
	
	var create_path = '<?php echo $create_path ?>';
	var content_path = '<?php echo $content_path ?>';
	
	function show_is_delete_stock_orders()
	{
		var is_nonactive = $('#delete-checked-button').attr('class');
		if(is_nonactive != 'r-z-h-s-delete nonactive')
		{
			var data = {'answer_path':'<?php echo WP_FOLDER.'ajax/modal/stocks/answer.delete.stock.orders.php' ?>'}
			open_modal('<?php echo WP_FOLDER.'ajax/modal/stocks/question.delete.stock.orders.php' ?>',data);
		}
	}
</script>
