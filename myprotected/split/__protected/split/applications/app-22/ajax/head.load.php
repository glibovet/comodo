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
            	<button class="r-z-h-s-new" type="button"></button>
                <button class="r-z-h-s-save" type="button"></button>
                <button class="r-z-h-s-close" type="button"></button>
                <button class="r-z-h-s-delete" type="button" id="delete-checked-button" 
                		 onclick="show_is_delete_orders();"></button>
                <button class="r-z-h-s-create" type="button" onclick="change_head(2); load_create(create_path);" title="Создать заказ">Создать &nbsp;&nbsp;&nbsp;<span>+</span></button>
            </div><!-- r-z-h-saving -->	
			</div>

			<div class="head-app head-hidden" id="head-app-2">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1); load_content(content_path);">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            <div class="r-z-h-saving">
            	<button class="r-z-h-s-new" type="button"></button>
                <button class="r-z-h-s-save" type="button"></button>
                <button class="r-z-h-s-close" type="button"></button>
                <button class="r-z-h-s-delete" type="button"></button>
            </div><!-- r-z-h-saving -->	
            </div>
            
            <div class="head-app head-hidden" id="head-app-3">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1);  load_content(content_path);">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            <div class="r-z-h-saving">
            	<button class="r-z-h-s-new" type="button"></button>
                <button class="r-z-h-s-save" type="button"></button>
                <button class="r-z-h-s-close" type="button"></button>
                <button class="r-z-h-s-delete" type="button"></button>
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
