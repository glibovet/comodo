<?php // ajax json action
	
	$data = array();
	
	$article_id = $_POST['article_id'];
	
	$result  = "
				<button class='close-modal' onclick='close_modal();'>Закрыть окно</button>
				<div class='modalW' id='modalW-1'>
					<h4>Действительно удалить отмеченные записи?</h4>
					
					<a  class='modalYes' href='javascript:void();' class='confirm' onclick=\"close_modal(); send_article_to_subscribers($article_id);\">Да, подтверждаю рассылку.</a>&nbsp;&nbsp;
					<a class='modalNo' href='javascript:void();' class='cancel' onclick=\"close_modal();\">Нет, отменить действие.</a>
				</div>
				";
	
	$data['message'] = $result;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
