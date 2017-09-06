<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	$create_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/create.load.php";
	$content_path = WP_FOLDER.APPS_DIR."app-".$app_id."/ajax/content.load.php";
 ?>
 <div id="unset_task_admin_ref_wrap" class="hidden"></div>
			
            <div class="head-app" id="head-app-1">
            
            <div class="r-z-h-filter"> 
            	<button class="r-z-h-f-search but-sort" id="but-sort-1" type="button" onclick="open_filtr(1);"></button>
                <button class="r-z-h-f-filling but-sort" id="but-sort-2" type="button" onclick="open_filtr(2);"></button>
                <button class="r-z-h-f-sorting but-sort" id="but-sort-3" type="button" onclick="open_filtr(3);"></button>
            </div><!-- r-z-h-filter -->
            
            <div class="r-z-h-saving">
            	<button class="rzh r-z-h-s-create nonactive" type="button" onclick="" 
                		title="Опция сейчас не активна.">Создать</button>
            </div><!-- r-z-h-saving -->	
			</div>

			<div class="head-app head-hidden" id="head-app-2">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1); load_content(content_path); unset_task_admin_ref();">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            <div class="r-z-h-saving">
                <button class="rzh r-z-h-s-create" id="form_task_button" type="button" onclick="form_task();" 
                		title="Оформить заявку">Оформить заявку</button>
                        
                <button class="rzh r-z-h-s-create hidden" id="drop_task_button" type="button" onclick="drop_task();" 
                		title="Опция сейчас недоступна.">Отколнить</button>
            
            	<button class="rzh r-z-h-s-create hidden nonactive" id="get_order_button" type="button" 
                title="Опция стент активна только после отметки всех товаров из заявки" onclick="get_order();">Принять заявку на склад</button>
            </div><!-- r-z-h-saving -->	
            </div>

<script type="text/javascript" language="javascript">

	var create_path = '<?php echo $create_path ?>';
	var content_path = '<?php echo $content_path ?>';
	
	function show_is_delete_orders()
	{
		var is_nonactive = $('#delete-checked-button').attr('class');
		if(is_nonactive != 'r-z-h-s-delete nonactive')
		{
			var data = {'answer_path':'<?php echo WP_FOLDER.'ajax/modal/answer.delete.orders.php' ?>'}
			open_modal('<?php echo WP_FOLDER.'ajax/modal/question.delete.orders.php' ?>',data);
		}
	}
	
	
	$(function(){
		});
</script>
