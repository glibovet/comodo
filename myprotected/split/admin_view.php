<link type="text/css" href="split/css/style.css" rel="stylesheet" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,400italic,600italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

  <div id="modal-window"></div>

  <div id="new-message-controller" class="hidden"></div>

  <div id="site-content">
	<div id="left-zone">
    <div style="
    		display:block;
            width:390px;
            min-height:100%;
            overflow:hidden;
    			">
        <div class="l-z-header">
        	<?php // start app ?>
        	<div class="l-z-h-power">
            	<div class="l-z-h-power-block">
            		<a	href="javascript:void(0);" title="Выход" onclick="jQuery.cookie('user_id',null); jQuery.cookie('user_id',null); document.location.reload();">
                        <div class="l-z-h-power-icon"></div>
                    </a>
                </div>
            </div><!-- l-z-h-power -->
            <div class="l-z-h-logo">
            	<div class="l-z-h-logo-block">
            		<a href="index.php" onclick="$.cookie('ajaxID',null); $.cookie('wpmenuParentActive','personal');"><div class="l-z-h-logo-icon"></div></a>
                </div>            	
            </div><!-- l-z-h-logo -->
            <div class="l-z-h-export">
            	<div class="l-z-h-export-block">
            	<a href="/" target="_blank"><div class="l-z-h-export-icon"></div></a>
                </div>
            </div><!-- l-z-h-export -->
        	<?php // end app ?>
        </div><!-- l-z-header -->
        
        <?php 
			require_once("split/admin_menu.php");
		?>
        
        </div><!-- style -->
        
    </div><!-- left-zone -->
    
    <div id="right-zone">
    	<?php 
			require_once("split/reloadFrame.php"); 
		?>
    </div><!-- right-zone -->
  </div><!-- site-content -->

<script type="text/javascript" language="javascript">
<?php
	if(!isset($_GET['item']) || $_GET['item'] != 29)
	{
		?>
		var cur_quant = parseInt($('#quant-new-messages').html());
		
		$(function(){
				updateMySelf();
				setInterval(function(){
						updateMySelf();
					},6000);
			});
		
		function updateMySelf()
		{
			$.post("split/ajax/load/action.json.quantNewMessages.php",{},function(data,status){
								if(status=='success')
								{
									cur_quant = parseInt($('#quant-new-messages').html());
									if(cur_quant != data.quant)
									{
										$('#zen_tickets').html(data.tasks);
										$('#zen_tasks').html(data.directorTasks);
										
										$('#tasksQ').html(data.tasksQ);
										$('#directorTasksQ').html(data.directorTasksQ);
										$('#messQ').html(data.messQ);
										
										$('#quant-new-messages').addClass('mactive');
										$('#quant-new-messages').html(data.quant);
										$('#quant-new-messages').animate({'top':'3px'},200,function(){
											$('#quant-new-messages').animate({'top':'13px'},800,'easeOutBounce',function(){
												$('#quant-new-messages').removeClass('mactive');
											});
											$('#zen_messages').html(data.last_mess);
										});
									}
								}
							},"json");
		}
		<?php
	}
?>
</script>