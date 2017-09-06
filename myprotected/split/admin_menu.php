<?php
	require_once("adminHelper.class.php");
	
	$ah = new adminHelper();
	
	// select data from database
	
	$user_query = "SELECT * FROM [pre]users WHERE `id`=".ADMIN_ID." AND `block`=0";
			
	$user_stmt = $dbh->prepare($user_query);
	$user_arr = $user_stmt->execute();
		
		$user = $user_arr->fetchallAssoc(); // ini USER
	
		
	$paid_orders = array(); // ini PAID_ORDERS
	
	foreach($paid_orders as $paid_id => $paid)
	{
		$paid_orders[$paid_id]['date_paid'] = $ah->deformat_date($paid['dateCreate']);
	}
	
	$messages = array(); // ini MESSAGES
	
	$query = "SELECT * FROM [pre]tasks WHERE `status`= 0 ORDER BY id LIMIT 1000";
			
	$_stmt = $dbh->prepare($query);
	$_arr = $_stmt->execute();
		
		$tasks = $_arr->fetchallAssoc(); // ini TASKS
	
	$user[0]['mess_quant'] = sizeof($paid_orders) + sizeof($messages) + sizeof($tasks); // Количество новых сообщений
	
	foreach($messages as $m_id => $mess)
	{
		$query = "SELECT name,fname FROM [pre]users WHERE `id`='".$mess['from_id']."' LIMIT 1";
		
		$_stmt = $dbh->prepare($query);
		$_arr = $_stmt->execute();
		
			$_res = $_arr->fetchallAssoc();
		
		$messages[$m_id]['friend_name']	= $ah->next_sub_str($_res[0]['name']." ".$_res[0]['fname'],15);
		$messages[$m_id]['sub_mess']	= $ah->next_sub_str($mess['message'],50);
		$messages[$m_id]['date_mess']	= $ah->deformat_date($mess['dateCreate']);
	}
	
	//******************************************************************************************************
	
	$parents_query = "SELECT * FROM [pre]admin_menu WHERE `type`=1 AND `parent`=0 AND `block`=0 ORDER BY order_id";
			
	$parents_stmt = $dbh->prepare($parents_query);
	$parents_arr = $parents_stmt->execute();
		
		$parents = $parents_arr->fetchallAssoc(); // ini PARENTS
	
	$data = array();
	
	foreach($parents as $parent)
	{
		$childs_query = "SELECT * FROM [pre]admin_menu WHERE `parent`='".$parent['id']."' AND `block`=0 ORDER BY order_id";
			
		$childs_stmt = $dbh->prepare($childs_query);
		$childs_arr = $childs_stmt->execute();
		
			$childs = $childs_arr->fetchallAssoc(); // ini CHILDS
		
		foreach($childs as $child_h => $child_v)
		{
			$query = "SELECT * FROM [pre]user_type_access WHERE `access` = 1 AND `menu_id` = '".$childs[$child_h]['id']."' AND `type_id` = '".$user[0]['type']."' LIMIT 1";
			
			$_stmt = $dbh->prepare($query);
			$_arr = $_stmt->execute();
		
				$_res = $_arr->fetchallAssoc();
			
			if(sizeof($_res) == 0)
			{
				unset($childs[$child_h]);
				continue;
			}
			
			$childs[$child_h]['class'] = "";
			if(isset($_COOKIE['wpmenuChildActive']))
			{
				if($child_v['alias'] == $_COOKIE['wpmenuChildActive'])
				{
					$childs[$child_h]['class'] = "active";
				}
			}
		}
		
		$parent['class'] = "l-z-left-menu-materials";
		$parent['classto'] = "";
		$parent['link'] = "javascript:void(0);";
		$parent['active'] = "";
		if(!isset($_COOKIE['wpmenuParentActive']) && $parent['alias'] == 'personal')
		{
			$parent['active'] = " active";
			$parent['classto'] = " lzrm-item";
		//}elseif(isset($_GET['control']) && $_GET['control'] == $parent['alias'])
		}elseif(isset($_COOKIE['wpmenuParentActive']) && $_COOKIE['wpmenuParentActive'] == $parent['alias'])
		{
			$parent['active'] = " active";
			$parent['classto'] = " lzrm-item";
		}
		
		switch($parent['alias'])
		{
			case 'personal'	: $parent['class'] = "l-z-left-menu-user"; break;
			case 'users'	: $parent['class'] = "l-z-left-menu-all_users"; break;
			case 'shop'		: $parent['class'] = "l-z-left-menu-shop"; break;
			case 'settings'	: $parent['class'] = "l-z-left-menu-settings"; break;
			case 'help'		: $parent['class'] = "l-z-left-menu-help"; break;
			default: break;
		}
		
		$parent['childs'] = $childs;
		
		array_push($data,$parent);
	}
	
	$paid_order_card_path = "split/applications/app-6/ajax/card.load.php";
?>

<div style="display:block;">
<table id="left-zone-table">
	<tr>
    <td style="padding:0 !important;">
		<div class="l-z-left-menu">
        	<ul>
            <?php
            foreach($data as $sec1)
			{
				if($sec1['alias'] == 'personal')
				{
					?>
                	<li class="l-z-user-li<?php echo $sec1['active'] ?>" id="sub-zen-<?php echo $sec1['alias'] ?>">
                    	<a href="<?php echo $sec1['link'] ?>" onclick="	$('.l-z-right-menu-item').hide(); $('#zen-<?php echo $sec1['alias'] ?>').show();
                    													$('.l-z-left-menu ul li').removeClass('active'); $('#sub-zen-<?php echo $sec1['alias'] ?>').addClass('active');
                                                                        $.cookie('wpmenuParentActive','<?php echo $sec1['alias'] ?>');" >
                		<div class="<?php echo $sec1['class'] ?> zen-left-menu-item">
                    		<div class="l-z-user-messages" id="quant-new-messages"><?php echo ($user['mess_quant'] ? $user['mess_quant'] : "!") ?></div>
                        	<div class="l-z-left-menu-text">
                        		<p><?php echo $user[0]['name'] ?></p>
                        	    <p><?php echo $user[0]['fname'] ?></p>
                        	</div>
                   		</div>
                		</a>
                    </li><!-- l-z-left-menu-user -->
                    <?php
				}else
				{
					?>
                <li id="sub-zen-<?php echo $sec1['alias'] ?>" class="<?php echo $sec1['active'] ?>">
                	<a href="<?php echo $sec1['link'] ?>" onclick="$('.l-z-right-menu-item').hide(); $('#zen-<?php echo $sec1['alias'] ?>').show();
                    											   $('.l-z-left-menu ul li').removeClass('active'); $('#sub-zen-<?php echo $sec1['alias'] ?>').addClass('active');
                                                                   $.cookie('wpmenuParentActive','<?php echo $sec1['alias'] ?>');" >
                	<div class="<?php echo $sec1['class'] ?> zen-left-menu-item">
                        <div class="l-z-left-menu-text"><?php echo $sec1['name'] ?></div>
                   </div>
                </a></li><!-- l-z-left-menu-item -->    
                	<?php
				} // end of else
			}
			?>
            </ul>
        </div><!-- l-z-left-menu -->
</td>        
<td style="padding:0 !important;">   
        <div class="l-z-right-menu" id="l-z-right-menu">
        <?php
        	foreach($data as $sec1)
			{
				?><ul class="l-z-right-menu-item<?php echo $sec1['classto'] ?>" id="zen-<?php echo $sec1['alias'] ?>"><?php
				foreach($sec1['childs'] as $sec2)
				{
					$landingPageName = "landingPage";
					$cardId = 0;
					
					if($sec2['alias']=='profile')
					{
						$cardId = ADMIN_ID;
						$landingPageName = "cardEdit";
					}
					
					if($sec2['alias']=='global-settings' || $sec2['alias']=='shop-manage')
					{
						$cardId = 1;
						$landingPageName = "cardView";
					}
					
					?>
					<a href="javascript:void(0);" onclick="loadPage('<?php echo $sec1['alias'] ?>','<?php echo $sec2['alias'] ?>',<?php echo $sec2['id'] ?>,<?php echo $cardId ?>,'<?php echo $landingPageName ?>',{start:'1'});
                    										$.cookie('wpmenuChildActive','<?php echo $sec2['alias'] ?>');
                                                            $('.l-z-right-menu-item li').removeClass('active');
                                                            $('#menuChild-<?php echo $sec2['id'] ?>').addClass('active');
                                                            " >
                    	<li class="<?php echo $sec2['class'] ?>" id="menuChild-<?php echo $sec2['id'] ?>">
                			<?php 
								echo $sec2['name']; 
								echo ($sec2['name'] == "Входящие заказы" ? " (<span id='tasksQ'>0</span>)  <span  class=\"right\">&rsaquo;</span>" : "");
								echo ($sec2['name'] == "Задания" ? " (<span id='directorTasksQ'>0</span>)  <span  class=\"right\">&rsaquo;</span>" : "");
								echo ($sec2['name'] == "Сообщения" ? " (<span id='messQ'>0</span>) <span  class=\"right\">&rsaquo;</span>" : "");
							?>
                		</li>
                    </a>
                    <?php
                    	if($sec2['name']=="Входящие заказы")
						{
							?>
							<ul class="tickets" id="zen_tickets">
                        	</ul>
							<?php
						}
						if($sec2['name']=="Задания")
						{
							?>
							<ul class="tickets" id="zen_tasks">
                        	</ul>
							<?php
						}
						if($sec2['name']=="Сообщения")
						{
							?>
							<ul class="tickets" id="zen_messages">
                        	</ul>
							<?php
						}
				}
				?></ul><?php
			}
		?>
        </div><!-- l-z-right-menu -->
</td>
</tr>
</table>
</div>