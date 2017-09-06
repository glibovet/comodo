<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class HomeController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    
	public function error404(){		
		$metaTitle = "Ошибка 404 - Страница не найдена";	
		if (LANG_PREFIX == "ua_") {$metaTitle 	= "Помилка 404 - Сторінку не знайдено";}	
		if (LANG_PREFIX == "en_") {$metaTitle 	= "Error 404 - Page Not Found";}	
		$this->set("metaTitle", $metaTitle);// title страницы		
		
		$metaKeys = "";
		$this->set("metaKeys", $metaKeys);//keywords страницы
		
		$metaDesc = "";
		$this->set("metaDesc", $metaDesc);//description страницы		
		
		
		$errDesc = "Упс, страницу не удалось найти :(";	
		if (LANG_PREFIX == "ua_") {$errDesc 	= "Упс, не вдалося знайти сторінку :(";}	
		if (LANG_PREFIX == "en_") {$errDesc 	= "Oops, page not found :(";}	
		$this->set("errDesc", $errDesc);//текст страницы
	}
	
	public function home()
    {
		$conn = ConnectionManager::get('default');
		
		if (LA == "ru"){
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: ".RS."");				  
				exit();
			}
		 
		
		/*
		echo "<pre>"; print_r($metaTitle); echo "</pre>";
		echo "<pre>"; print_r($metaKeys); echo "</pre>";
		echo "<pre>"; print_r($metaDesc); echo "</pre>";exit();*/
		
		$mainBanList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."name as data, file, target, link
					FROM osc_banners
					WHERE `block`=0 AND `pos_id`=1
					ORDER BY `order_id`
					LIMIT 40")->fetchAll('assoc');
		$this->set("mainBanList", $mainBanList);// Список баннеров в шапке на главной странице
		//echo "<pre>"; print_r($mainBanList); echo "</pre>"; exit();
		
		$stockBanList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."data as data, file, target, link
					FROM osc_banners
					WHERE `block`=0 AND `pos_id`=2
					ORDER BY `order_id`
					LIMIT 40")->fetchAll('assoc');
		$this->set("stockBanList", $stockBanList);// Список баннеров акционных на главной странице
		//echo "<pre>"; print_r($stockBanList); echo "</pre>"; exit();	
		
		$companyBanList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."data as data, file, target, link
					FROM osc_banners
					WHERE `block`=0 AND `pos_id`=3
					ORDER BY `order_id`
					LIMIT 40")->fetchAll('assoc');
		$this->set("companyBanList", $companyBanList);// Список баннеров о компании на главной странице
		//echo "<pre>"; print_r($companyBanList); echo "</pre>"; exit();	
		
		$popularList = $conn->query("
				SELECT P.id, P.".LANG_PREFIX."name as name, P. ".RATE_PREFIX."price as price, P.".RATE_PREFIX."sale_price as sale_price, P.alias,
						(SELECT crop FROM osc_files_ref WHERE ref_id = M.prod_id AND ref_table = 'shop_products' LIMIT 1) as img,
						(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_name,
						(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=P.obj_id LIMIT 1) as obj_name
						FROM osc_shop_prod_group_ref as M
						LEFT JOIN `osc_shop_products` as P ON P.id=M.prod_id
						WHERE group_id='4' AND P.block=0
						ORDER BY P.dateCreate DESC
						LIMIT 100
		")->fetchAll('assoc');
		$this->set("popularList", $popularList);// Список популярных товаров
		//echo "<pre>"; print_r($popularList); echo "</pre>"; exit();	
		
		$newProdList = $conn->query("
				SELECT P.id, P.".LANG_PREFIX."name  as name, P. ".RATE_PREFIX."price as price, P.".RATE_PREFIX."sale_price as sale_price, P.alias,
						(SELECT crop FROM osc_files_ref WHERE ref_id = M.prod_id AND ref_table = 'shop_products' LIMIT 1) as img,
						(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_name,
						(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=P.obj_id LIMIT 1) as obj_name
						FROM osc_shop_prod_group_ref as M
						LEFT JOIN `osc_shop_products` as P ON P.id=M.prod_id
						WHERE group_id='1' AND P.block=0
						ORDER BY P.dateCreate DESC
						LIMIT 100
		")->fetchAll('assoc');
		$this->set("newProdList", $newProdList);// Список новинок товарове
		//echo "<pre>"; print_r($newProdList); echo "</pre>"; exit();			
		
		$mpBlogList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content, alias, filename,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias
					FROM osc_articles as M
					WHERE `block`=0 AND `cat_id`!=3
					ORDER BY `dateCreate` DESC
					LIMIT 3")->fetchAll('assoc');
		$this->set("mpBlogList", $mpBlogList);// Список новостей на главной странице
		//echo "<pre>"; print_r($mpBlogList); echo "</pre>"; exit();			
		
		
		$mpCompanyNews = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content, alias, filename,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias
					FROM osc_articles as M
					WHERE `block`=0 AND `cat_id`=3
					ORDER BY `dateCreate` DESC
					LIMIT 3")->fetchAll('assoc');
		$this->set("mpCompanyNews", $mpCompanyNews);// Список новостей компании на главной страницее
		//echo "<pre>"; print_r($mpCompanyNews); echo "</pre>"; exit();
		
		$seoArticle = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content, alias, filename,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias
					FROM osc_articles as M
					WHERE `block`=0 AND `cat_id`=4
					ORDER BY `dateCreate` DESC
					LIMIT 1")->fetch('assoc');
		$this->set("seoArticle", $seoArticle);// SEO статья на главной страницее
		//echo "<pre>"; print_r($seoArticle); echo "</pre>"; exit();	
				
		$mpCatalog = $conn->query("
            SELECT C.".LANG_PREFIX."name as name, C.alias, C.id, C.filename,
			(SELECT COUNT(P.id) FROM `osc_shop_products` AS P WHERE P.block=0 AND P.cat_id = C.id) as count_prods 
			FROM osc_shop_catalog as C
			WHERE C.block = 0
			ORDER BY C.pos 
			LIMIT 100
        ")->fetchAll('assoc');
		$this->set("mpCatalog", $mpCatalog);// Список категорий товаров на главной странице
		//echo "<pre>"; print_r($mpCatalog); echo "</pre>"; exit();	
		
		$mpMf = $conn->query("
            SELECT M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."country as country, M.alias, M.id, M.filename, M.crop
			FROM osc_shop_mf as M
			WHERE M.block = 0
			ORDER BY M.".LANG_PREFIX."name 
			LIMIT 18
        ")->fetchAll('assoc');
		$this->set("mpMf", $mpMf);// Список фабрик на главной странице
		//echo "<pre>"; print_r($mpMf); echo "</pre>"; exit();
		
    }
	
	public function register()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$_email 		= strip_tags(str_replace("'","\'",$_POST['reg_login']));
		$_pass  		= strip_tags(str_replace("'","\'",$_POST['reg_password']));
		$_pass_con 		= strip_tags(str_replace("'","\'",$_POST['reg_password_confirm']));
		
		$_true_pass = $_pass;
		
		if(filter_var($_email,FILTER_VALIDATE_EMAIL))
		{
			if(strlen($_pass) >=5)
			{
				if($_pass_con === $_pass)
				{
					$user_exist = $conn->query(
					"
					SELECT id FROM osc_users WHERE login='$_email' LIMIT 1
					"
					)->fetch('assoc');
					
					if (!$user_exist)
					{
					$_pass = md5($_pass);	
					$success = $conn->query("
					INSERT INTO osc_users (login, pass) VALUES ('$_email',  '$_pass')
					"
					);
						if($success){ 
						$data['status'] = "success"; 
						if (LANG_PREFIX == '') { $data['message'] = "Успешная регистрация";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Successful registration";}
						
						$_user = $conn->query("
						SELECT * FROM osc_users WHERE login='$_email' LIMIT 1
						")->fetch('assoc');						
						$user_id = $_user['id'];
						
						if($_user){	$_SESSION['online']=$_user['id'];}
						
						$updateCart = $conn->query("
						UPDATE osc_shop_cart
							SET `uid`='$user_id'
							WHERE  `session_id`='".SESID."'
						");
						
						$updateLike = $conn->query("
						UPDATE osc_shop_like
							SET `uid`='$user_id'
							WHERE  `session_id`='".SESID."'
						");
						
						$to  = $_email; 
						$subject = "Регистрация на It Fur Line";
						$message = ' 
						<html> 
						<head> 
						<title>Регистрация на It Fur Line</title> 
						</head> 
						<body> 
						<p style="color: green;">Уважаемый пользователь</p>
						<p>Вы прошли регистрацию на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
						
						<p>Данные для авторизации:</p>
						<p>ЛОГИН: '.$_email.'</p>
						<p>ПАРОЛЬ: '.$_true_pass.'</p>
						
						<hr />
						<p><strong>Спасибо, что выбрали нас.</strong></p>
						<hr />
						</body> 
						</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
						}
						
					}
					else{
						if (LANG_PREFIX == '') { $data['message'] = "Пользователь с таким e-mail уже зарегистрирован";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "This email is already registered";}
						}				
				}else{
						if (LANG_PREFIX == '') { $data['message'] = "Повторный пароль не совпадает";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Repeated password is different";}
					}
			}else{
					if (LANG_PREFIX == '') { $data['message'] = "Пароль сликом короткий";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Password is too short";}
				}
		}else{
				if (LANG_PREFIX == '') { $data['message'] = "Введите действующий email адресс";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter a valid email address";}
			}
	echo json_encode($data);
	exit();
	}
	
	
	
	public function login()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$_email 		= strip_tags(str_replace("'","\'",$_POST['login']));
		$_pass  		= strip_tags(str_replace("'","\'",$_POST['password']));		
		$_pass = md5($_pass);
		
		$_user = $conn->query("
		SELECT * FROM osc_users WHERE login='$_email' LIMIT 1
		")->fetch('assoc');					
		$user_id = $_user['id'];
		
		if($_user){
			if($_user['pass'] == $_pass){
				
				$_SESSION['online']=$_user['id'];
				$data['status'] = "success";
				if (LANG_PREFIX == '') { $data['message'] = "Успешная аторизация";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Successful authorization";}
				
				$updateCart = $conn->query("
				UPDATE osc_shop_cart
					SET `uid`='$user_id'
					WHERE  `session_id`='".SESID."'
				");
				
				$updateLike = $conn->query("
				UPDATE osc_shop_like
					SET `uid`='$user_id'
					WHERE  `session_id`='".SESID."'
				");
				
				}
				else {
					if (LANG_PREFIX == '') { $data['message'] = "Неверный пароль";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Incorrect password";}
					}
			}
			else{
				if (LANG_PREFIX == '') { $data['message'] = "Пользователь не найден";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "User is not found";}
				}
			
			echo json_encode($data);
	exit();
		
	}
	
	public function logout()
    {
		$_SESSION['online'] = null;
		unset($_SESSION['online']);
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".RS."catalog/"); 
		exit();
	}
	
	public function sendNewPass()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$_email 		= strip_tags(str_replace("'","\'",$_POST['np_login']));
		
		if(filter_var($_email,FILTER_VALIDATE_EMAIL))
		{
				$user_exist = $conn->query(
				"
				SELECT id FROM osc_users WHERE login='$_email' LIMIT 1
				"
				)->fetch('assoc');
				
				if (!$user_exist)
				{
					if (LANG_PREFIX == '') { $data['message'] = "Пользователь с таким e-mail не зарегистрирован";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "This email is not registered";}
				}
				else{
				function generatePassword($length = 8){
				  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
				  $numChars = strlen($chars);
				  $string = '';
				  for ($i = 0; $i < $length; $i++) {
					$string .= substr($chars, rand(1, $numChars) - 1, 1);
				  }
				  return $string;
				}
				
				$pass = generatePassword(8);
				$_true_pass = $pass;	
					
				$_pass = md5($pass);
					
				$success = $conn->query("
				UPDATE osc_users
						SET `pass`='$_pass'
						WHERE  `login`='$_email'
				"
				);
					if($success){ 
					$data['status'] = "success"; 
					if (LANG_PREFIX == '') { $data['message'] = "Новый пароль отправлен на Ваш e-mail";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "New password sent to your e-mail";}
					
					$_user = $conn->query("
					SELECT * FROM osc_users WHERE login='$_email' LIMIT 1
					")->fetch('assoc');						
					$user_name = $_user['name'];
										
					$to  = $_email; 
					$subject = "Новый пароль на It Fur Line";
					$message = ' 
					<html> 
					<head> 
					<title>Создан новый пароль на It Fur Line</title> 
					</head> 
					<body> 
					<p style="color: green;">Уважаемый пользователь</p>
					<p>Вы изменили свой пароль для авторизации на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
					
					<p>Данные для авторизации:</p>
					<p>ЛОГИН: '.$_email.'</p>
					<p>ПАРОЛЬ: '.$_true_pass.'</p>
					
					<hr />
					<p><strong>Спасибо, что выбрали нас.</strong></p>
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
					}						
				}
			
		}else{
				if (LANG_PREFIX == '') { $data['message'] = "Введите действующий email адресс";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter a valid email address";}
			}
	echo json_encode($data);
	exit();
	}
	
	public function changePersInfo()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$user_id 		= UID;
		$_name 			= strip_tags(str_replace("'","\'",$_POST['name']));
		$_lname 		= strip_tags(str_replace("'","\'",$_POST['lname']));
		$_email 		= strip_tags(str_replace("'","\'",$_POST['email']));
		$_phone 		= $_POST['phone'];
		$_adress		= strip_tags(str_replace("'","\'",$_POST['adress']));
		$_confirm		= (int)$_POST['confirm'];
		
		if(filter_var($_email,FILTER_VALIDATE_EMAIL))
		{
				
			if(strlen($_phone) >=10)
			{
				$user_exist = $conn->query(
				"
				SELECT id FROM osc_users WHERE login='$_email' AND id !='$user_id' LIMIT 1
				"
				)->fetch('assoc');
				
				if (!$user_exist)
				{
					$success = $conn->query("
						UPDATE osc_users
								SET `name`='$_name',`lname`='$_lname', `login`='$_email', `phone`='$_phone', `delivery_address`='$_adress', `newsletter`='$_confirm'
								WHERE  `id`='$user_id'
						");
						
					if($success){ 
					$data['status'] = "success"; 
					
					if (LANG_PREFIX == '') { $data['message'] = "Изменения внесены в базу";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Changes made to database";}
									
					$to  = $_email; 
					$subject = "Личные данные на It Fur Line";
					$message = ' 
					<html> 
					<head> 
					<title>Изменения в личном кабинете на It Fur Line</title> 
					</head> 
					<body> 
					<p style="color: green;">Уважаемый пользователь</p>
					<p>Вы изменили персональную информацию на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
					
					<p>Новые данные:</p>
					<p>Логин: '.$_email.'</p>
					<p>Имя: '.$_name.'</p>
					<p>Фамилия: '.$_lname.'</p>
					<p>Телефон: '.$_phone.'</p>
					<p>Адрес: '.$_adress.'</p>
					
					<hr />
					<p><strong>Спасибо, что выбрали нас.</strong></p>
					<hr />
					</body> 
					</html>';
	
					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
					mail($to, $subject, $message, $headers);
					}
					
				}
				else{
					if (LANG_PREFIX == '') { $data['message'] = "Пользователь с таким e-mail уже зарегистрирован";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "This email is already registered";}
				}
			}
			else{
				if (LANG_PREFIX == '') { $data['message'] = "Введите корректный номер тел.";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Please enter a valid phone";}
			}
		}else{
				if (LANG_PREFIX == '') { $data['message'] = "Введите действующий email адресс";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter a valid email address";}
			}
	echo json_encode($data);
	exit();
	}	
	
	public function userChangePass()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$user_id 		= UID;
		$old_password 			= $_POST['old_password'];
		$new_password 			= strip_tags(str_replace("'","\'",$_POST['new_password']));
		$new_password_repeat 	= strip_tags(str_replace("'","\'",$_POST['new_password_repeat']));
		
		$old_pass = md5($old_password);
		$_true_pass = $new_password;
		
		$user_exist = $conn->query("
				SELECT login, name FROM osc_users WHERE `id`='$user_id' AND `pass`='$old_pass' LIMIT 1
				")->fetch('assoc');
		//"<pre>"; print_r($user_exist); echo "</pre>"; exit();
		
		$_email = $user_exist['login'];
		$user_name = $user_exist['name'];
		
		
		if($user_exist)
		{
			if(strlen($new_password) >=5)
			{
				if($new_password === $new_password_repeat)
				{				
					
				$_pass = md5($new_password);
				
				$success = $conn->query("
						UPDATE osc_users
						SET `pass`='$_pass'
						WHERE  `id`='$user_id'
				");
				
					if($success){ 
					if (LANG_PREFIX == '') { $data['message'] = "Новый пароль отправлен на Ваш e-mail";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "New password sent to your e-mail";}
															
					$to  = $_email; 
					$subject = "Новый пароль на It Fur Line";
					$message = ' 
					<html> 
					<head> 
					<title>Создан новый пароль на It Fur Line</title> 
					</head> 
					<body> 
					<p style="color: green;">Уважаемый пользователь</p>
					<p>Вы изменили свой пароль для авторизации на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
					
					<p>Данные для авторизации:</p>
					<p>ЛОГИН: '.$_email.'</p>
					<p>НОВЫЙ ПАРОЛЬ: '.$_true_pass.'</p>
					
					<hr />
					<p><strong>Спасибо, что выбрали нас.</strong></p>
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
					}
					else{
							$data['message'] = "Не удалось изменить пароль (";
					}
				}
				else{
						if (LANG_PREFIX == '') { $data['message'] = "Повторный пароль не совпадает";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Repeated password is different";}
				}
			}
			else{
					if (LANG_PREFIX == '') { $data['message'] = "Новый пароль сликом короткий";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "New password is too short";}
			}
		}
		else{
				if (LANG_PREFIX == '') { $data['message'] = "Старый пароль не верный";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Old password is not correct";}
			}
	echo json_encode($data);
	exit();
	}
	
		
	
	public function callOffOrder()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$user_id 		= UID;
		$order_id 		= $_POST['order_id'];
		
		$status_exist = $conn->query("
				SELECT status FROM osc_shop_orders WHERE `status`<=1 AND `id`='$order_id' LIMIT 1
				")->fetch('assoc');
		//"<pre>"; print_r($status_exist); echo "</pre>"; exit();
		
		if($status_exist)
		{				
			
			$success = $conn->query("
					UPDATE osc_shop_orders
					SET `status`=5
					WHERE  `id`='$order_id'
			");
			
			if($success){ 
			$data['status'] = "success"; 
			
			if (LANG_PREFIX == '') { $data['message'] = "Заказ отменен!";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Order Cancelled!";}
			
			}
			else{
					if (LANG_PREFIX == '') { $data['message'] = "Не удалось изменить статус заказа! Свяжитесь с администратором.";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to change the status of the order! Contact administrator.";}
			}
		}
		else{
				if (LANG_PREFIX == '') { $data['message'] = "Не отменен! Свяжитесь с администратором.";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to change! Contact administrator.";}
			}
	echo json_encode($data);
	exit();
	}
	
	public function cart()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$p_id 			= (int)$_POST['prod_id'];		
		$p_url 			= $_POST['prod_url'];
		$qty 			= (isset($_POST['qty']) ? (int)$_POST['qty'] : 1);
		$size			= (isset($_POST['size']) ? (int)$_POST['size'] : 0);
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];
		
		$cartQty = "0";
		$cartSum = "0";
		$prodSum = "0";
		$open_modal = "#";	
		$open_order = "#";
		
		if ($size){
			$existingProd = $conn->query(
			"
			SELECT id, quant
					FROM osc_shop_cart
					WHERE `uid`='$user_id'				
					AND  `session_id`='$session_id'
					AND `prod_id`=$p_id
					ORDER BY id DESC
					LIMIT 1
			"
			)->fetch('assoc');
			
			if($existingProd)
			{	
					$quant=$qty+$existingProd['quant'];
					
			
					$updateProd = $conn->query(
					"
					UPDATE osc_shop_cart
						SET `quant`='$quant'
						WHERE `uid`='$user_id' 
						AND `session_id`='$session_id'
						AND `prod_id`=$p_id
					"
					);
			
			}
			else
			{
				//echo "<pre>"; print_r($date); echo "</pre>"; exit();
				
				$cartSizes = $conn->query("
							SELECT M.value
										FROM osc_shop_chars_prod_ref as M 
										JOIN osc_shop_chars as C ON M.char_id=C.id 
										WHERE 
											M.value 	!= '' AND	
											C.alias 	= 'size'  	AND 
											M.prod_id 	= '$p_id'	AND 
											C.block 	= 0
										ORDER BY M.id
										LIMIT 10
						")->fetchAll('assoc');
				$this->set("cartSizes", $cartSizes);// Список размеров товара
				
				$oll_sizes = serialize($cartSizes);
				
				$cartSizeValues = $conn->query("
								SELECT M.size, M.breast_val, M.waist_val, M.hip_val, M.sleeve_val
									FROM osc_shop_prod_size_ref as M 
									WHERE M.prod_id = '$p_id' AND
									M.breast_val != ''
									ORDER BY M.order_id
									LIMIT 20
								")->fetchAll('assoc');
				$this->set("cartSizeValues", $cartSizeValues);// Список значений размеров товара
				
				$sizeValues = serialize($cartSizeValues);
				
				$eddProd = $conn->query("
					INSERT INTO osc_shop_cart  (uid, session_id, prod_id, prod_url, quant, size, oll_sizes, size_val, dateCreate, dateModify) 
							 VALUES 
							 ('$user_id', '$session_id', '$p_id', '$p_url', '$qty', '$size', '$oll_sizes', '$sizeValues', '$date', '$date')
					"
					);		
									
			}
			
			if(isset($eddProd) || isset($updateProd))
				{					
				$data['status'] = "success"; 
				
				if (LANG_PREFIX == '') { $data['message'] = "Товар добавлен в корзину";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Product added to cart";}
				
				$countQuery = $conn->query(
						"
						SELECT 
								SUM(quant) as cart_quant
								FROM osc_shop_cart
								WHERE uid='$user_id' 
								AND `session_id`='$session_id'
						"
						)->fetch('assoc');
				//echo "<pre>"; print_r($countQuery); echo "</pre>"; exit();
				
				if ($countQuery['cart_quant']) {
					$cartQty = $countQuery['cart_quant'];
					$open_modal = "#modal-4"; 
					$open_order = "/cart/";
					}
				
				$cartList =  $conn->query(
					"
					SELECT C.*, R.cat_id, 
					(SELECT ".LANG_PREFIX."name FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_name,
					(SELECT sku FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_sku,
					(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_price,
					(SELECT file FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_file,
					(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_crop,
					(SELECT ".LANG_PREFIX."name FROM osc_shop_catalog WHERE id=R.cat_id ORDER BY id LIMIT 1) as cat_name
					FROM osc_shop_cart as C
					LEFT JOIN `osc_shop_cat_prod_ref` as R ON R.prod_id=C.prod_id
					WHERE C.uid = '".UID."' AND
					C.session_id='".SESID."'
					ORDER BY dateModify
					"
					)->fetchAll('assoc');
				$this->set("cartList", $cartList);// Список товаров в корзине
				//echo "<pre>"; print_r($cartList); echo "</pre>"; exit();
				
				foreach ($cartList as $cart){
					$prodSum = $cart['quant']*$cart['prod_price'];
					$cartSum += $prodSum;
					}
					
				$formatCartSum = number_format($cartSum, 0, '.', '.');	
				
			
				$data['total_quant'] = $cartQty;				
				$data['total_sum'] 	 = $formatCartSum;
				$data['open_modal'] = $open_modal;
				$data['open_order'] = $open_order;				
				
				
				ob_start();
				
				foreach ($cartList as $cartItem) { 
						$formatProdPrice = number_format($cartItem['prod_price'], 0, '.', '.');
						$oll_sizes  = unserialize($cartItem['oll_sizes']);		// Список размеров товара?>
                        <div class="buy-item" id="cart-item-<?= $cartItem['id'] ?>">
                            <a href="<?= $cartItem['prod_url'] ?>">
                                <img src="/img/split/files/shop/products/crop/<?= $cartItem['prod_crop']?>" alt="<?= $cartItem['prod_name'] ?>">
                            </a>
                            <div class="model">
                                <h5><?= $cartItem['cat_name'] ?></h5>
                                <h6><?= $cartItem['prod_name'] ?></h6>
                                
                                <div class="prod_cart_sizes">
                                    <button type="button" class="prod_cart_size_btn product-size<?= $cartItem['id'] ?>-dd" onclick=" $('#product-size<?= $cartItem['id'] ?>-dd').slideDown(900);">
                                        <i><span id="product-selected-size<?= $cartItem['id'] ?>">
                                        <?php if ($cartItem['size']){ echo $cartItem['size']; }
                                        else { echo $oll_sizes['0']['value'];}?>
                                        </span></i>
                                    </button>
            
                                    <ul id="product-size<?= $cartItem['id'] ?>-dd" class="prod_cart_size_ul">
                                        <?php foreach ($oll_sizes as $prodSize)
                                        { 
                                        $dop_class = "";
                                        if ($prodSize['value'] == $cartItem['size']) {$dop_class = "active";}
                                        ?>
                                            <li id="size-val-<?= $prodSize['value'] ?>" class="<?= $dop_class ?>"><a data-val="<?= $prodSize['value'] ?>" href="javascript:void(0);" onclick="mainScript.changeProdSize(<?= $cartItem['id'] ?>,'<?= $prodSize['value'] ?>');"><?= $prodSize['value'] ?></a></li>
                                        <?php
                                        }?>
                                    </ul>
                                </div>
                                
                                <p class="code">код:  <?= $cartItem['prod_sku'] ?></p>
                            </div>
                            <p class="price"><?= $formatProdPrice ?> <?= CURNAME ?></p>
                            <div class="sum" id="sum_<?= $cartItem['prod_id'] ?>">
                                <button class="minus change" onClick="mainScript.minusProdQty(<?= $cartItem['prod_id'] ?>);"></button>
                                <input type="number" value="<?= $cartItem['quant'] ?>" size="5" class="count" onChange="mainScript.changeProdQty(<?= $cartItem['id'] ?>, this.value, <?= $cartItem['prod_id'] ?>, '<?= RATE_PREFIX ?>');">
                                <button class="plus change" onClick="mainScript.plusProdQty(<?= $cartItem['prod_id'] ?>);"></button>
                            </div>
                            <i class="trash" onClick="mainScript.delCartProd(<?= $cartItem['id'] ?>, '<?= RATE_PREFIX ?>');"></i>
                        </div>
				<?php }
				$data['fastCartHtml'] = ob_get_contents();
				
				ob_end_clean();
				
		}
		}else{
			if (LANG_PREFIX == '') { $data['message'] = "Укажите размер";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Select a size";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function prodSize()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'',];
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$item_id 		= (int)$_POST['item_id'];
		$size			= $_POST['size'];
		
		$updateProd = $conn->query(
				"
				UPDATE osc_shop_cart
					SET `size`='$size'
					WHERE `uid`='$user_id' 
					AND `session_id`='$session_id'
					AND `id`=$item_id
				"
				);
				
		if(isset($updateProd))
		{
			$data['status'] = "success"; 
			if (LANG_PREFIX == '') { $data['message'] = "Размер изменен";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Size changed";}
		}
		else {
			if (LANG_PREFIX == '') { $data['message'] = "Не удалось изменить размер";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Failed to size changed";}
			}		
			
	echo json_encode($data);
	exit(); 
	}
	
	
	
	
	
	
	public function like()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$p_id 			= (int)$_POST['prod_id'];		
		$p_url 			= $_POST['prod_url'];
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];	
		
		$existingProd = $conn->query(
		"
		SELECT id
				FROM osc_shop_like
				WHERE `uid`='$user_id'				
				AND  `session_id`='$session_id'
				AND `prod_id`=$p_id
				ORDER BY id DESC
				LIMIT 1
		"
		)->fetch('assoc');
		
		if($existingProd)
		{	
				$data['status'] = "success"; 
				if (LANG_PREFIX == '') { $data['message'] = "Добавлен в избранное";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Added to favorites";}
		}
		else
		{			
			$eddProd = $conn->query("
				INSERT INTO osc_shop_like  (uid, session_id, prod_id, prod_url, dateCreate) 
						 VALUES 
						 ('$user_id', '$session_id', '$p_id', '$p_url', '$date')
				"
				);		
								
		}
		
		if(isset($eddProd))
		{
			$data['status'] = "success"; 			
			if (LANG_PREFIX == '') { $data['message'] = "Добавлен в избранное";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Added to favorites";}
			
			$countQuery = $conn->query(
					"
					SELECT 
							COUNT(id) as like_quant
							FROM osc_shop_like
							WHERE uid='$user_id' 
							AND `session_id`='$session_id'
					"
					)->fetch('assoc');
		
		
			$data['total_quant'] = $countQuery['like_quant'];
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function delLike()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;	
		$item_id 		= $_POST['item_id'];
		
		$data = ['status'=>'failed','message'=>'',];
		
		$delateProd = $conn->query(
				"
				DELETE FROM osc_shop_like
					WHERE `id`='$item_id' AND
					`uid`='$user_id' AND 
					`session_id`='$session_id'
				"
				);
				
		if(isset($delateProd))
		{			
			$data['status'] = "success"; 
			if (LANG_PREFIX == '') { $data['message'] = "Успешное удаление";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Successful delete";}
			
			$countQuery = $conn->query("
					SELECT 
							COUNT(id) as like_quant
							FROM osc_shop_like
							WHERE uid='$user_id' AND 
							`session_id`='$session_id'
					"
					)->fetch('assoc');
		
		
			$data['total_quant'] = $countQuery['like_quant'];
		}
			
	echo json_encode($data);
	exit();
		
	}
	public function review()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;	
		$rating 		= (int)$_POST['size'];
		$comment 		= strip_tags(str_replace("'","\'",$_POST['review']));
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>''];
		
		if($user_id){
			if(strlen($comment) >=5){
			$eddReview = $conn->query("
				INSERT INTO osc_article_comments (user_id, comment, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$user_id', '$comment', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$selectReview = $conn->query("
						SELECT id
								FROM osc_article_comments
								WHERE user_id='$user_id'
								ORDER BY id DESC
								LIMIT 1
						"
						)->fetch('assoc');
					
					$item_id = $selectReview['id'];
					
					$filename = "files";
					
					// Upload files
					
					
					if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
					{
						$file_path = "../webroot/img/split/files/users/";
						
						$files_upload = $this->Helper->mtvc_add_files_file_miltiple(array(
								'path'			=>$file_path,
								'name'			=>5,
								'pre'			=>"comm_",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>3333,
								'max_h'			=>3333,
								'files'			=>$filename,
								'resize_path'	=>$file_path."crop/",
								'resize_w'		=>386,
								'resize_h'		=>585,
								'resize_path_2'	=>"0",
								'resize_w_2'	=>0,
								'resize_h_2'	=>0
							  ));
						if($files_upload)
						{
							foreach($files_upload as $file_upload)
							{
								$query = "INSERT INTO osc_files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('article_comments', '$item_id', '$file_upload', '0', 'webroot/img/split/files/users/')";
								
								$conn->query($query);
							}
						}
					}	else{
						
						$data['message'] = count($_FILES);
						
						
						echo json_encode($data);
						exit();
						}
					$data['status'] = "success"; 
					if (LANG_PREFIX == '') { $data['message'] = "Отзыв добавлен и вскоре будет размещен.";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Reviewed added and will be available soon.";}
				}else{
					if (LANG_PREFIX == '') { $data['message'] = "Не удалось добавить отзыв";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to add review";}
				}
			}else{
				if (LANG_PREFIX == '') { $data['message'] = "Поле <span>Ваш отзыв</span> не заполнено";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Field <span>Your comment</span> is not filled";}
			}
		}else{
			if (LANG_PREFIX == '') { $data['message'] = "<a href='#modal-1'>Авторизируйтесь</a> для добавления отзыва";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<a href='#modal-1'>Sign in</a> to add a comment";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function contactForm()
    {
		$conn = ConnectionManager::get('default');
		
		if (UID) {$u_id = UID;}
		else {$u_id = "";}
		$name			= $_POST['name'];
		$mail 			= strip_tags(str_replace("'","\'",$_POST['email']));
		$comment 		= strip_tags(str_replace("'","\'",$_POST['comment']));
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($name)
		{
			if(filter_var($mail,FILTER_VALIDATE_EMAIL))
			{	
				if(strlen($comment) >=5)
				{	
					
						$eddMessage = $conn->query("
						INSERT INTO osc_site_messages (user_id, message, name, email, dateCreate) 
								 VALUES 
								 ('$u_id', '$comment', '$name', '$mail', '$date')
						"
						);
						
						$message = "";
						
						$to  = TECHMAIL; 
							$subject = "Новое сообщение из сайта itfurline.com";
							$message .= ' 
							<html> 
							<head> 
							<title>Новое сообщение из сайта itfurline.com</title> 
							</head> 
							<body> 
							<h2 style="color: #686b60;">Поступило новое сообщение из сайта <a href="http://itfurline.com/">itfurline.com</a> </h2>
							
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Email отправителя: <span style="color: #ef692a;">'.$mail.'</span></p>
							
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>					
							<hr />
							<p><strong>Сообщение:</strong></p>
							<p>'.$comment.'</p>
							<hr />
							</body> 
							</html>';
		
							$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
							$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
							mail($to, $subject, $message, $headers);
						
							$data['status'] = "success";							
							if (LANG_PREFIX == '') { $data['message'] = "Сообщение успешно отправлено";}
							elseif (LANG_PREFIX == 'en_') { $data['message'] = "Message sent successfully";}
							
				}
				else
				{	
					if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Сообщение*</span>";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Message*</span> is not filled.";}
				}
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Введите корректный <span>Email*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter the correct <span>Email*</span>";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Имя*</span>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Name*</span> is not filled.";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	
	
	public function addSiteComm()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$title  		= strip_tags(str_replace("'","\'",$_POST['title']));
		$coment 		= strip_tags(str_replace("'","\'",$_POST['coment']));
		$rating			= (isset($_POST['rating']) ? (int)$_POST['rating'] : 5);
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($user_id)
		{	
			if(strlen($coment) >=5)
			{	
				
				$selectUser = $conn->query("
					SELECT name
							FROM osc_users
							WHERE id='$user_id'
							LIMIT 1
					"
					)->fetch('assoc');
				
				$user_name = $selectUser['name'];
				
				$eddReview = $conn->query("
				INSERT INTO osc_site_comments (user_id, comment, name, caption, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$user_id', '$coment', '$user_name', '$title', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$message = "";
					
					$to  = TECHMAIL; 
						$subject = "Новый отзыв на itfurline.com";
						$message .= ' 
						<html> 
						<head> 
						<title>Прокомментирован сайт itfurline.com</title> 
						</head> 
						<body> 
						<h2 style="color: #686b60;">Новый отзыв на сайте <a href="http://itfurline.com/">itfurline.com</a> </h2>
											
						<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$user_name.'</span></p>			
						<hr />
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Тама: <span style="color: #0000;">'.$title.'</span></p>	
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #0000;">'.$coment.'</span></p>	
						</body> 
						</html>';
		
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
						mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					if (LANG_PREFIX == '') { $data['message'] = "Сообщение успешно отправлено";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Message sent successfully";}
				}
				else
				{
					if (LANG_PREFIX == '') { $data['message'] = "Не удалось добавить запись!";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to add an entry!";}
				}							
				
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Комментарий слишком короткий!";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Comment too short!";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "<a href='#modal-1'>Авторизируйтесь!</a>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<a href='#modal-1'>Sign in!</a>";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
		
	
	public function addProdComm()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$title  		= strip_tags(str_replace("'","\'",$_POST['title']));
		$coment 		= strip_tags(str_replace("'","\'",$_POST['coment']));
		$rating			= (isset($_POST['rating']) ? (int)$_POST['rating'] : 5);
		$prod_id 		= $_POST['com_pid'];
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($user_id)
		{	
			if(strlen($coment) >=5)
			{	
				
				$selectUser = $conn->query("
					SELECT name
							FROM osc_users
							WHERE id='$user_id'
							LIMIT 1
					"
					)->fetch('assoc');
				
				$user_name = $selectUser['name'];
				
				$eddReview = $conn->query("
				INSERT INTO osc_shop_product_comments (prod_id, user_id, comment, name, caption, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$prod_id', '$user_id', '$coment', '$user_name', '$title', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$selectProd = $conn->query("
						SELECT alias, name
								FROM osc_shop_products
								WHERE id='$prod_id'
								LIMIT 1
						"
						)->fetch('assoc');
					
					$item_name = $selectProd['name'];
					$item_alias = $selectProd['alias'];
				
					$message = "";
					
					$to  = TECHMAIL; 
						$subject = "Новый отзыв на itfurline.com";
						$message .= ' 
						<html> 
						<head> 
						<title>Прокомментирован товар на itfurline.com</title> 
						</head> 
						<body> 
						<h2 style="color: #686b60;">Новый отзыв на товар <a href="http://itfurline.com/catalog/product/'.$item_alias.'">'.$item_name.'</a> на <a href="http://itfurline.com/">itfurline.com</a> </h2>
											
						<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$user_name.'</span></p>			
						<hr />
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Тама: <span style="color: #0000;">'.$title.'</span></p>	
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #0000;">'.$coment.'</span></p>	
						</body> 
						</html>';
		
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
						mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					if (LANG_PREFIX == '') { $data['message'] = "Сообщение успешно отправлено";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Message sent successfully";}
				}
				else
				{
					if (LANG_PREFIX == '') { $data['message'] = "Не удалось добавить запись!";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to add an entry!";}
				}							
				
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Комментарий слишком короткий!";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Comment too short!";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "<a href='#modal-1'>Авторизируйтесь!</a>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<a href='#modal-1'>Sign in!</a>";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function addArtComm()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$coment 		= strip_tags(str_replace("'","\'",$_POST['coment']));
		$art_id 		= $_POST['art_id'];
		$rating			= "5";
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($user_id)
		{	
			if(strlen($coment) >=5)
			{	
				
				$selectUser = $conn->query("
					SELECT name
							FROM osc_users
							WHERE id='$user_id'
							LIMIT 1
					"
					)->fetch('assoc');
				
				$user_name = $selectUser['name'];
				
				$eddReview = $conn->query("
				INSERT INTO osc_article_comments (art_id, user_id, comment, name, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$art_id', '$user_id', '$coment', '$user_name', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$selectArt = $conn->query("
						SELECT alias, name
								FROM osc_articles
								WHERE id='$art_id'
								LIMIT 1
						"
						)->fetch('assoc');
					
					$item_name = $selectArt['name'];
					$item_alias = $selectArt['alias'];
				
					$message = "";
					
					$to  = TECHMAIL; 
						$subject = "Новый отзыв на itfurline.com";
						$message .= ' 
						<html> 
						<head> 
						<title>Прокомментированна статья на itfurline.com</title> 
						</head> 
						<body> 
						<h2 style="color: #686b60;">Новый отзыв на статью <a href="http://itfurline.com/blog/'.$item_alias.'">'.$item_name.'</a> на <a href="http://itfurline.com/">itfurline.com</a> </h2>
											
						<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$user_name.'</span></p>			
						<hr />	
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #0000;">'.$coment.'</span></p>	
						</body> 
						</html>';
		
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
						mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					if (LANG_PREFIX == '') { $data['message'] = "Сообщение успешно отправлено";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Message sent successfully";}
				}
				else
				{
					if (LANG_PREFIX == '') { $data['message'] = "Не удалось добавить запись!";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to add an entry!";}
				}							
				
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Комментарий слишком короткий!";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Comment too short!";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "<a href='#modal-1'>Авторизируйтесь!</a>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<a href='#modal-1'>Sign in!</a>";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function callback()
    {
		$conn = ConnectionManager::get('default');
		
		$name			= $_POST['name'];
		$phone 			= $_POST['phone'];
		
		
		if($name)
		{	
			if(strlen($phone) >=17)
			{	
					
				$message = "";
				
				$to  = TECHMAIL; 
					$subject = "Обратный звонок на itfurline.com";
					$message .= ' 
					<html> 
					<head> 
					<title>Запрос на обратный звонок из сайта itfurline.com</title> 
					</head> 
					<body> 
					<h2 style="color: #686b60;">Поступил новый запрос на обратный звонок из сайта <a href="http://itfurline.com/">itfurline.com</a> </h2>
										
					<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>	
					<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Телефон отправителя: <span style="color: #ef692a;">'.$phone.'</span></p>				
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					if (LANG_PREFIX == '') { $data['message'] = "Сообщение успешно отправлено";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Message sent successfully";}							
				
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Введите корректный <span>немер телефона*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter the correct <span>phone*</span>";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Имя*</span>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Name*</span> is not filled.";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
}
