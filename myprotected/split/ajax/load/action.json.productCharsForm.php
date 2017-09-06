<?php // ajax json action
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);

	$product_cat_id	= $_POST['product_cat_id'];
	$charsGroup		= $_POST['charsGroup'];
	$chars			= $_POST['chars'];
	$cat_id			= $_POST['cat_id'];
	
	$result = "";
	
	if($product_cat_id == $cat_id)
	{
		$result .= "            	
			<br>
                <p title='Группа характеристик'>Группа свойств: <b>".$charsGroup['name']."</b></p>
                <br>
				<table class='chars-table'>";
				foreach($chars as $char)
				{
					$result .= "
                	<tr>
                    	<td>".$char['name']."".($char['measure']!="" ? ", ".$char['measure'] : "")." (RU)</td>
                        <td>
                        	<input id='char-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='".$char['value']."' name='char[".$char['id']."]' size='25' maxlength='100'>
						</td>
						<td> Полное значение (RU): </td>
                        <td>
                        	<input id='char2-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='".$char['value2']."' name='char2[".$char['id']."]' size='25' maxlength='100'>
						</td>
					</tr>					
					<tr>
						<td>".$char['name']."".($char['measure']!="" ? ", ".$char['measure'] : "")." (UA)</td>
						<td>
							<input id='char3-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='".$char['ua_value']."' name='char3[".$char['id']."]' size='25' maxlength='100'>
						</td>
						<td> Полное значение (UA): </td>
						<td>
							<input id='char4-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='".$char['ua_value2']."' name='char4[".$char['id']."]' size='25' maxlength='100'>
						</td>
					</tr>
					<tr>
						<td>".$char['name']."".($char['measure']!="" ? ", ".$char['measure'] : "")." (EN)</td>
						<td>
							<input id='char5-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='".$char['en_value']."' name='char5[".$char['id']."]' size='25' maxlength='100'>
						</td>
						<td> Полное значение (EN): </td>
						<td>
							<input id='char6-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='".$char['en_value2']."' name='char6[".$char['id']."]' size='25' maxlength='100'>
						</td>
					</tr>
					<tr>
						<td colspan='4'></td>
					</tr>
					";
				}
                $result .= "
				</table>
			";
	}else
	{
				// Вытягиваем данные о группе свойств
				$charsGroup = array();
				
				if($cat_id)
				{
					$query = "SELECT M.id, M.name FROM [pre]shop_chars_groups as M LEFT JOIN [pre]shop_cat_chars_group_ref as R on M.id = R.group_id WHERE R.cat_id = ".$cat_id." LIMIT 1";
					$charsGroupMassive = $ah->rs($query);
					
					if($charsGroupMassive)
					{
						$charsGroup = $charsGroupMassive[0];
					}
				}
				
				// Вытягиваем значения свойств
				$chars = array();
				
				if($charsGroup)
				{
					$query = "SELECT M.id as id, M.name as name, M.measure as measure
							 FROM [pre]shop_chars as M
							 WHERE M.group_id=".$charsGroup['id']." 
							 ORDER BY pos 
							 LIMIT 100";
					$charsList = $ah->rs($query);
					
					if($charsList)
					{
						$chars = $charsList;
						
						$result .= "            	
			<br>
                <p title='Группа характеристик'>Группа свойств: <b>".$charsGroup['name']."</b></p>
                <br>
				<table class='chars-table'>";
				foreach($chars as $char)
				{
					$result .= "
                	<tr>
                    	<td>".$char['name']."".($char['measure']!="" ? ", ".$char['measure'] : "")." (RU)</td>
                        <td>
                        	<input id='char-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='' name='char[".$char['id']."]' size='25' maxlength='100'>
						</td>
						<td> Полное значение: (RU)</td>
                        <td>
                        	<input id='char2-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='' name='char2[".$char['id']."]' size='25' maxlength='100'>
						</td>
					</tr>					
					<tr>
						<td>".$char['name']."".($char['measure']!="" ? ", ".$char['measure'] : "")." (UA)</td>
						<td>
							<input id='char3-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='' name='char3[".$char['id']."]' size='25' maxlength='100'>
						</td>
						<td> Полное значение (UA): </td>
						<td>
							<input id='char4-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='' name='char4[".$char['id']."]' size='25' maxlength='100'>
						</td>
					</tr>
					<tr>
						<td>".$char['name']."".($char['measure']!="" ? ", ".$char['measure'] : "")." (EN)</td>
						<td>
							<input id='char5-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='' name='char5[".$char['id']."]' size='25' maxlength='100'>
						</td>
						<td> Полное значение (EN): </td>
						<td>
							<input id='char6-".$char['id']."' class='my-field' type='text' placeholder='".$char['name']."' value='' name='char6[".$char['id']."]' size='25' maxlength='100'>
						</td>
					</tr>
					<tr>
						<td colspan='4'></td>
					</tr>
					";
				}
                $result .= "
				</table>
			";
					}else
					{
						$result .= "<br>
                					<p title='Группа характеристик'>Для групы свойств: <b>".$charsGroup['name']."</b> еще не назначены свойства.</p>";
					}
				}else{
					$result .= "<br>
                					<p title='Группа характеристик'>Для текущей категории еще не назначена группа свойств.</p>";
					}
				
	}
	
	$data['message'] = $result;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
