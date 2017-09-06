<?php 
	
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Session\DatabaseSession;


class AjaxController extends AppController
{
    public function index()
    {					
		$conn = ConnectionManager::get('default');	
	
		// GET POST DATA
		
		$_email 			= $_POST['reg_login'];
		$_pass  			= $_POST['reg_password'];
		$_pass_con 			= $_POST['reg_password_confirm'];
	

	// VALIDATE POST DATA
	
	if(filter_var($_email,FILTER_VALIDATE_EMAIL))
	{
		if(strlen($_pass) >=5)
		{
			if($_pass_con == $_pass)
			{
				$query = "SELECT id FROM [pre]users WHERE login='$_email' LIMIT 1";
				$userExists = $db->exec_query($query,1);
				
				if(!$userExists)
				{				
					$hash_pass = md5(base64_encode($secret_key.$_pass));
					
					$query = "INSERT INTO [pre]users (login, pass, name, lname) VALUES ('$_email', '$hash_pass', '$_name', '$_lname')";
					$registerStatus = $db->exec_query($query,0,1);
					
					if($registerStatus)
					{
						$userId = mysql_insert_id();
						
						$data['message'] = "Вы успешно зарегистрированы.";
						$_SESSION['account_id'] = $userId;
						$data['status'] = 'success';
						
						$eFrom = "info@dveri-prestige.kiev.ua";
						$eTo = $_email;
						$eSubject = "Успешная регистрация на Dveri-Prestige.kiev.ua";
						$eMessage = "
									<h2>Приветствуем, $_name $_lname !</h2>
									<p>Вы успешно создали аккаунт на сайте <a href='http://dveri-prestige.kiev.ua'>Dveri-Prestige.kiev.ua</a></p>
									<p>Ваши параметри для входа в личный кабинет:</p>
									<table>
										<tr>
											<td>Логин: </td>
											<td><b>$_email</b></td>
										</tr>
										<tr>
											<td>Пароль: </td>
											<td>$_pass</td>
										</tr>
									</table>
									<p>Спасибо что выбрали нас!</p>
									";
						$data['emailStatus'] = $helper->send_letter($eTo,$eFrom,$eSubject,$eMessage,"Dveri Prestige Store");
							
					}else{
						$data['message'] = "Не удалось создать акаунт по техническим причинам, пожалуйста обратитесь в техподдержку.";
						}
				
				}else{
					$data['message'] = "Пользователь с таким Email уже зарегистрирован.";
					}
			}else{
					$data['message'] = "Повторный пароль не совпадает";
			}
		}else{
				$data['message'] = "Пароль сликом короткий<br>(минимум 5 символов)";
		}
	}else{
			$data['message'] = "<small>Введите действующий email адресс";
		}


	$db->db_destroy();
	
	echo json_encode($data);
	exit();
	}
}