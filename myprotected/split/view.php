<?php
	//$controller->callApp('N',$dbh);
	
	$wp_login = false;
	if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != null && trim($_COOKIE['user_id']) !== "" && $_COOKIE['user_id'])
	{
		$query = "SELECT M.*, T.name as userGroupName, T.block as userGroupBlock, T.admin_enter as userGroupAdminEnter  
					FROM [pre]users as M, [pre]users_types as T 
					WHERE M.id='".$_COOKIE['user_id']."' AND M.type=T.id 
					LIMIT 1";
		
		$userDataStmt = $dbh->prepare($query);
		$userDataArr = $userDataStmt->execute();
		$userData = $userDataArr->fetchallAssoc();
		
		//echo '<pre>'; print_r($userData); echo '</pre>';
		
		$userData = $userData[0];
		
		if($userData['block']==0 && $userData['userGroupBlock']==0 && $userData['active']==1 && $userData['userGroupAdminEnter']==1)
		{
			$wp_login = true;
		}
	}
	define("WP_LOGIN",$wp_login);
	if(WP_LOGIN)
	{
		require_once("admin_view.php");
	}else
	{
		require_once("admin_login.php");
	}
?>