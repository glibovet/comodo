<?php 
	//********************
	//** WEB INSPECTOR
	//********************
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
                <button class="r-z-h-s-delete" type="button"></button>
                <button class="r-z-h-s-create" type="button" onclick="change_head(2);" title="Создать пользователя">Создать &nbsp;&nbsp;&nbsp;<span>+</span></button>
            </div><!-- r-z-h-saving -->	
			</div>

			<div class="head-app head-hidden" id="head-app-2">
            <div class="r-z-h-return">
                <a href="javascript:void(0);" onclick="change_head(1);">
                	<div class="return-header-icon"></div>
                </a>
            </div><!-- r-z-h-return -->
            
            <div class="r-z-h-saving">
            	<button class="r-z-h-s-new" type="button"></button>
                <button class="r-z-h-s-save" type="button"></button>
                <button class="r-z-h-s-close" type="button"></button>
                <button class="r-z-h-s-delete" type="button"></button>
                <button class="r-z-h-s-create" type="button">Создать &nbsp;&nbsp;&nbsp;<span>+</span></button>
            </div><!-- r-z-h-saving -->	
            </div>

<script type="text/javascript" language="javascript">
	$(function(){
		});
</script>
